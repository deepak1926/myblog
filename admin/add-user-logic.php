<?php
    
    require("config/database.php");
// require './config/database.php';


    //get  form data if submit button was clicked
    if(isset($_POST['submit'])){
        $first_name = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        $createpassword = filter_var($_POST['createpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_admin = filter_var($_POST['userrole'],FILTER_SANITIZE_NUMBER_INT);
        
        
        $avatar = $_FILES['avatar'];
        
        if(!$first_name){
            $_SESSION['add-user'] = "Please enter your first name";
        }else if(!$last_name){
            $_SESSION['add-user'] = "Please enter your last name";
        }else if(!$username){
            $_SESSION['add-user'] = "Please enter your username";
        }else if(!$email){
            $_SESSION['add-user'] = "Please enter a valid email";
        }else if(strlen($createpassword) < 8 || strlen($confirmpassword)<8){
            $_SESSION['add-user'] = "Password should be 8+ length";
        }elseif(!$avatar['name']){
            $_SESSION['add-user'] = "Please add avatar";
        }else{
            if($createpassword!==$confirmpassword){
                $_SESSION['add-user'] = "Password is not match";
                
            }else{
                $createpassword = password_hash($createpassword,PASSWORD_DEFAULT);
                $sql = "SELECT * FROM users WHERE email='$email' OR username = '$username'";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    $_SESSION['signup'] = "This email id  or username is already registered with us!";
                }else{
                    $time = time(); //make each image name unique using current timestamp
                    $avatar_name = $time.$avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    $avatar_destination = '../images/'.$avatar_name;
                    $allowed_files = ['png','jpg','jpeg'];
                    $extension = explode('.',$avatar_name);
                    $extension = end($extension);
                    if(in_array($extension,$allowed_files)){
                        if($avatar['size']<1000000){
                            move_uploaded_file($avatar_tmp_name,$avatar_destination);
                        }else{
                            $_SESSION['add-user'] = 'File size too big. Should be less than 1mb';
                        }
                     }else{
                        $_SESSION['add-user'] = "File should be png, jpg, or jpeg";
                    }
                }
            }
        }
        //redirect back to signup page if there was any problem
        if(isset($_SESSION['add-user'])){
            $_SESSION['add-user-data'] = $_POST;
            header("location: ".ROOT_URL."admin/add-user.php");
            die();
        }else{
            $sql = "INSERT INTO users (id,first_name, last_name, username, email, password, avatar,is_admin) VALUES (null,'$first_name', '$last_name', '$username', '$email', '$createpassword', '$avatar_name','$is_admin')";
            $result = mysqli_query($conn, $sql);
            if(!mysqli_errno($conn)){
                
                //redire t to login page with success message
                $_SESSION['add-user-success'] = "New user $firstname $lastname added successfully.";
                header("location: ".ROOT_URL."admin/manage-users.php");
                die();
            }
        }
    }else{
        //if button was not clicked, bouce back to add user page
        header('location: '.ROOT_URL.'admin/add-user.php');
        die();
    }
