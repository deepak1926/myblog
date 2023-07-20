<?php
include "partials/header.php";

//get back form data if there was a registration error
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['cratpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;

//detele signup data session
unset($_SESSION['add-user-data']);
?>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Add User</h2>
        <?php
            if(isset($_SESSION['add-user'])){?>
            <div class="alert_message error">
                <p><?php 
                    echo $_SESSION['add-user'];
                    unset($_SESSION['add-user']);
                    ?>
                </p>
            </div>
        <?php
            }
        ?>
        <form action="<?= ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data" method="post">
        <input type="text" name="firstname" id="" value = '<?=$firstname?>' placeholder="First Name">
            <input type="text" name="lastname" id="" value = '<?=$lastname?>' placeholder="Last Name">
            <input type="text" name="username" id="" value = '<?=$username?>' placeholder="Username">
            <input type="email" name="email" id=""  value = '<?=$email?>' placeholder="Email">
            <input type="password" name="createpassword"  value = '<?=$createpassword?>' id="" placeholder="Create Password">
            <input type="password" name="confirmpassword" value = '<?=$confirmpassword?>' id="" placeholder="Confirm Password">
            <select name="userrole" id="" value>
                <option value="0">Author</option>
                <option value="1">Admin</option>

            </select>
            <div class="form_control">
                <label for="avatar">User Avatar</label>
                <input type="file" id="avatar" name="avatar">
            </div>
            <button type="submit" class="btn" name="submit">Add User</button>
        </form>
    </div>
</section>
<?php
include "../partials/footer.php";
?>