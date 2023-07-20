<?php
require "config/database.php";
// require './config/database.php';



if(isset($_POST['submit'])){
    //get updated form data
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    //check for valid input
    if(!$title){
        $_SESSION['edit-category'] = "Please enter title";
    }else if(!$description){
        $_SESSION['edit-category'] = "Please enter description";
    }else{
        // update user
        $query = "UPDATE categories SET title = '$title', description='$description' WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn,$query);
        if(mysqli_errno($conn)){
            $_SESSION['edit-category'] = "Failed to update category";

        }else{
            $_SESSION['edit-user-success'] = "Category $title updated successfully";
        }
    }
}
header('location: '.ROOT_URL.'admin/manage-categories.php');
die();