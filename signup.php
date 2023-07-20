<?php
 
    require 'config/database.php';

    //get back form data if there was a registration error
    $firstname = $_SESSION['signup-data']['firstname'] ?? null;
    $lastname = $_SESSION['signup-data']['lastname'] ?? null;
    $username = $_SESSION['signup-data']['username'] ?? null;
    $email = $_SESSION['signup-data']['email'] ?? null;
    $createpassword = $_SESSION['signup-data']['cratpassword'] ?? null;
    $confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
    //detele signup data session
    unset($_SESSION['signup-data']);

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
        <h2>Sign Up</h2>
        <?php
            if(isset($_SESSION['signup'])){?>
            <div class="alert_message error">
                <p><?php 
                    echo $_SESSION['signup'];
                    unset($_SESSION['signup']);
                    ?>
                </p>
            </div>
        <?php
            }
        ?>
        <form action="<?=ROOT_URL?>signup-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" id="" value = '<?=$firstname?>' placeholder="First Name">
            <input type="text" name="lastname" id="" value = '<?=$lastname?>' placeholder="Last Name">
            <input type="text" name="username" id="" value = '<?=$username?>' placeholder="Username">
            <input type="email" name="email" id=""  value = '<?=$email?>' placeholder="Email">
            <input type="password" name="createpassword"  value = '<?=$createpassword?>' id="" placeholder="Create Password">
            <input type="password" name="confirmpassword" value = '<?=$confirmpassword?>' id="" placeholder="Confirm Password">
            <div class="form_control">
                <label for="avatar">User Avatar</label>
                <input type="file" id="avatar" name="avatar">
            </div>
            <button type="submit" class="btn" name="submit">Sign Up</button>
            <small>Already have an account? <a href="./signin.php">Sign in</a></small>
        </form>
    </div>
</section>
</body></html>