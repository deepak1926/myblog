<?php
require "config/database.php";
// require './config/database.php';



if(isset($_POST['submit'])){
    //get updated form data
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'],FILTER_SANITIZE_NUMBER_INT);


    //check for valid input
    if(!$firstname){
        $_SESSION['edit-user'] = "Please enter your first name";
    }else if(!$lastname){
        $_SESSION['edit-user'] = "Please enter your last name";
    }else{
        // update user
        $query = "UPDATE users SET first_name = '$firstname', last_name='$lastname', is_admin=$is_admin WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn,$query);
        if(mysqli_errno($conn)){
            $_SESSION['edit-user'] = "Failed to update user";

        }else{
            $_SESSION['edit-user-success'] = "User $firstname $lastname updated successfully";
        }
    }
}
header('location: '.ROOT_URL.'admin/manage-users.php');
die();