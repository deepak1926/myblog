<?php
    
    require("config/database.php");

    //get signup form data if signup button was clicked
    if(isset($_POST['submit'])){
        $first_name = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        $createpassword = filter_var($_POST['createpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $confirmpassword = filter_var($_POST['confirmpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'];
        
        if(!$first_name){
            $_SESSION['signup'] = "Please enter your first name";
        }else if(!$last_name){
            $_SESSION['signup'] = "Please enter your last name";
        }else if(!$username){
            $_SESSION['signup'] = "Please enter your username";
        }else if(!$email){
            $_SESSION['signup'] = "Please enter a valid email";
        }else if(strlen($createpassword) < 8 || strlen($confirmpassword)<8){
            $_SESSION['signup'] = "Password should be 8+ length";
        }elseif(!$avatar['name']){
            $_SESSION['signup'] = "Please add avatar";
        }else{
            if($createpassword!==$confirmpassword){
                $_SESSION['signup'] = "Password is not match";
                
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
                    $avatar_destination = 'images/'.$avatar_name;
                    $allowed_files = ['png','jpg','jpeg'];
                    $extension = explode('.',$avatar_name);
                    $extension = end($extension);
                    if(in_array($extension,$allowed_files)){
                        if($avatar['size']<1000000){
                            move_uploaded_file($avatar_tmp_name,$avatar_destination);
                        }else{
                            $_SESSION['signup'] = 'File size too big. Should be less than 1mb';
                        }
                     }else{
                        $_SESSION['signup'] = "File should be png, jpg, or jpeg";
                    }
                }
            }
        }
        //redirect back to signup page if there was any problem
        if(isset($_SESSION['signup'])){
            $_SESSION['signup-data'] = $_POST;
            header("location: ".ROOT_URL."signup.php");
            die();
        }else{
            $sql = "INSERT INTO users (id,first_name, last_name, username, email, password, avatar,is_admin) VALUES (null,'$first_name', '$last_name', '$username', '$email', '$createpassword', '$avatar_name',0)";
            $result = mysqli_query($conn, $sql);
            if(!mysqli_errno($conn)){
                
                //redire t to login page with success message
                $_SESSION['signup-success'] = "Resistration successfully. Please Login!";
                header("location: ".ROOT_URL."signin.php");
                die();
            }
        }
    }else{
        //if button was not clicked, bouce back to signup page
        header('location: '.ROOT_URL.'signup.php');
        die();
    }
