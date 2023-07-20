<?php
 require 'config/database.php';
 $username_email = $_SESSION['signin-data']['username_email'] ?? null ;
 $password = $_SESSION['signin-data']['password'] ?? null;
 unset($_SESSION['signin-data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Multipage Blog Website</title>
    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- ICONSOUT CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONT(MONTSERRAT) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+Bhai+2&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,800;1,900&family=Poppins:ital@1&display=swap"
        rel="stylesheet">
</head>

<body>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Sign In</h2>
        <?php
            if(isset($_SESSION['signup-success'])){?>
            <div class="alert_message success">
                <p><?php 
                    echo $_SESSION['signup-success'];
                    unset($_SESSION['signup-success']);
                    ?>
                </p>
            </div>
        <?php
            }elseif(isset($_SESSION['signin'])){
        ?>
        <div class="alert_message error">
                <p><?php 
                    echo $_SESSION['signin'];
                    unset($_SESSION['signin']);
                    ?>
                </p>
            </div>
        <?php
            }
        ?>
        <form action="<?=ROOT_URL?>signin-logic.php" enctype="multipart/form-data" method="post">
            <input type="text" name="username_email" id="" value="<?=$username_email?>" placeholder="Username or Email">
            <input type="password" name="password" id="" value="<?=$password?>" placeholder="Password">
            
            <button type="submit" class="btn" name="submit">Sign In</button>
            <small>Don't have account? <a href="./signup.php">Sign Up</a></small>
        </form>
    </div>
</section>
</body></html>