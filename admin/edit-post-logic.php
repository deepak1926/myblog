<?php
require 'config/database.php';
// require './config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ?: 0;
    //validate form data
    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalide form data on edit post page";
    } else if (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalide form data on edit post page";
    } else if (!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalide form data on edit post page";
    } else {
        //delete existing thumbnail if new thumbnail is available
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            //work on new  thumbnail
            $time = time(); //make each image name unique using current timestamp
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination = '../images/' . $thumbnail_name;
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if (in_array($extension, $allowed_files)) {
                if ($thumbnail['size'] < 2000000) {
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination);
                } else {
                    $_SESSION['edit-post'] = 'Couldn\'t update post. Thumbnail size too big. Should be less than 2mb';
                }
            } else {
                $_SESSION['edit-post'] = "Couldn\'t update post. Thumbnail should be png, jpg, or jpeg";
            }
        }
    }
    //redirect back with form data to add-post if there is any problem
    if (isset($_SESSION['edit-post'])) {
        $_SESSION['edit-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        //set is_featured of all posts to 0 if is_featured for this post is 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
        }
        //set thumbnail name if a new one was uploaded, else keep old thumbnail name
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;
        $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn, $query);
    }
    if (!mysqli_errno($conn)) {
        $_SESSION['edit-post-success'] = "Post updated successfully";
    }
}
header('location:' . ROOT_URL . 'admin/');
die();
