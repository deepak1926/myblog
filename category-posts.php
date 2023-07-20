<?php
include 'partials/header.php';

//fetch posts from database
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
    $posts = mysqli_query($conn, $query);
} else {
    header('location' . ROOT_URL . 'blog.php');
    die();
}
?>
<header class="category_title">
    <?php
    //fetch category from categories table using category_id of post
    $category_id = $id;
    $category_query = "SELECT * FROM categories WHERE id = $category_id";
    $category_result = mysqli_query($conn, $category_query);
    $category = mysqli_fetch_assoc($category_result);

    ?>
    <h2><?= $category['title'] ?></h2>
</header>
<!-- =======================END OF CATEGORY TITLE========================= -->
<?php if(mysqli_num_rows($posts)>0) : ?>
<section class="posts">
    <div class="container posts_container">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post_thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                </div>
                <div class="post_info">

                    <h3 class="post_title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                    <p class="post_body">
                        <?= substr($post['body'], 0, 300) ?>...
                    </p>
                    <div class="post_author">
                        <?php
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = mysqli_query($conn, $author_query);
                        $author = mysqli_fetch_assoc($author_result);

                        ?>
                        <div class="post_author-avatar">
                            <img src="./images/<?= $author['avatar'] ?>" alt="">
                        </div>
                        <div class="post_author-info">
                            <h5><?= "{$author['first_name']} {$author['last_name']}" ?></h5>
                            <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
        <?php endwhile ?>
    </div>
</section>
<?php else: ?>
    <div class="alert_message error lg">
        <p>No posts found for this category</p>
    </div>
<?php endif ?>



<!-- =============================END OF POST========================== -->


<section class="category_buttons">

    <div class="container category_buttons-container">
        <?php
        $all_categories = "SELECT * FROM categories";
        $all_categories_result = mysqli_query($conn, $all_categories);
        ?>
        <?php while ($category = mysqli_fetch_assoc($all_categories_result)) : ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category_button"><?= $category['title'] ?></a>
        <?php endwhile ?>
    </div>
</section>
<!-- =============================END OF CATEGORY========================== -->
<?php
include 'partials/footer.php';
?>