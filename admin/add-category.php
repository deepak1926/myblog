<?php
    include "partials/header.php";


    //get back form data if invalid
    $title = $_SESSION['add-category-data']['title'] ?? null;
    $description = $_SESSION['add-category-data']['description'] ?? null;

    unset($_SESSION['add-category-data']);

?>
<section class="form_section">
    <div class="container form_section-container">
        <h2>Add Category</h2>
        <?php if (isset($_SESSION['add-category'])) : //shows if add user was successfully
    ?>
        <div class="alert_message error">
            <p><?php
                echo $_SESSION['add-category'];
                unset($_SESSION['add-category']);
                ?>
            </p>
        </div>
    <?php endif ?>

        <form action="<?=ROOT_URL?>admin/add-category-logic.php" method="post">
            <input type="text" name="title" value="<?=$title?>" id="" placeholder="Title">
            <textarea name="description" rows="4" placeholder="Description"><?=$description?></textarea>
            <button type="submit" class="btn" name="submit">Add Category</button>
        </form>
    </div>
</section>
<?php
    include "../partials/footer.php";
?>