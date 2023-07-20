<?php
include 'partials/header.php';
//fetch featured post from database
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($conn, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

//fetch 9 posts from database
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($conn, $query);
?>

<!-- show featured post if there's any -->
<?php if (mysqli_num_rows($featured_result) == 1) : ?>
    <section class="featured">
        <div class="container featured_container">
            <div class="post_thumbnail">
                <img src="./images/<?= $featured['thumbnail'] ?>" alt="">
            </div>
            <div class="post_info">
                <?php
                //fetch category from categories table using category_id of post
                $category_id = $featured['category_id'];
                $category_query = "SELECT * FROM categories WHERE id = $category_id";
                $category_result = mysqli_query($conn, $category_query);
                $category = mysqli_fetch_assoc($category_result);

                ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $featured['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                <h2 class="post_title"><a href="<?= ROOT_URL ?>post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
                <p class="post_body"><?= substr($featured['body'], 0, 300) ?>...</p>
                <div class="post_author">
                    <?php
                    $author_id = $featured['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($conn, $author_query);
                    $author = mysqli_fetch_assoc($author_result);

                    ?>

                    <div class="post_author-avatar"><img src="./images/<?= $author['avatar'] ?>" alt=""></div>
                    <div class="post_author-info">
                        <h5><?= "{$author['first_name']} {$author['last_name']}" ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>
<!-- =========================END OF FEATURED======================= -->

<section class="posts <?=$featured ?'':'section_extra-margin'?>">
    <div class="container posts_container">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post_thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>" alt="">
                </div>
                <div class="post_info">
                    <?php
                    //fetch category from categories table using category_id of post
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id = $category_id";
                    $category_result = mysqli_query($conn, $category_query);
                    $category = mysqli_fetch_assoc($category_result);

                    ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category_button"><?= $category['title'] ?></a>
                    <h3 class="post_title"><a href="<?=ROOT_URL?>post.php?id=<?=$post['id']?>"><?= $post['title'] ?></a></h3>
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