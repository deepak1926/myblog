<?php
require 'config/database.php';
if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if (!$name) {
        $_SESSION['send'] = "Please enter your name";
    }  else if (!$email) {
        $_SESSION['send'] = "Please enter a valid email";
    }else if (!$message) {
        $_SESSION['send'] = "Please enter your message";
    }

    //redirect back to signup page if there was any problem
    if (isset($_SESSION['send'])) {
        $_SESSION['send-data'] = $_POST;
        header("location: " . ROOT_URL . "contact.php");
        die();
    } else {
        $sql = "INSERT INTO contact_us (id,name,email, message) VALUES (null,'$name',  '$email', '$message')";
        $result = mysqli_query($conn, $sql);
        if (!mysqli_errno($conn)) {

            // Redirect the user to the contact page
            $_SESSION['send-success'] = "Query sent successfully.";
            header("location: " . ROOT_URL . "contact.php");
            // Send the email
            mail('deepaksatankar111@gmail.com', 'Contact Form Submission', $message, 'From: ' . $email);
            die();
        }
    }
}
