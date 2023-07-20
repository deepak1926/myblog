<?php
include 'partials/header.php';
//get back form data if there was a registration error
$name = $_SESSION['send-data']['name'] ?? null;
$email = $_SESSION['send-data']['email'] ?? null;
$message = $_SESSION['send-data']['message'] ?? null;
//detele signup data session
unset($_SESSION['send-data']);

?>
<section class="form_section">
  <div class="container form_section-container">
    <?php
    if (isset($_SESSION['send'])) { ?>
      <div class="alert_message error">
        <p><?php
            echo $_SESSION['send'];
            unset($_SESSION['send']);
            ?>
        </p>
      </div>
    <?php
    } elseif (isset($_SESSION['send-success'])) { ?>
      <div class="alert_message success">
        <p><?php
            echo $_SESSION['send-success'];
            unset($_SESSION['send-success']);
            ?>
        </p>
      </div>
    <?php } ?>
    <h2>Contact Us</h2>
    <form action="<?= ROOT_URL ?>contact-logic.php" method="post">
      <input type="name" value="<?= $name ?>" name="name" placeholder="Your Name">
      <input type="email" value="<?= $email ?>" name="email" placeholder="Your Email">
      <textarea name="message" placeholder="Your Message"><?= $message ?></textarea>
      <button type="submit" class="btn" name="submit">Send</button>
    </form>
  </div>
</section>



<?php
include 'partials/footer.php';
?>