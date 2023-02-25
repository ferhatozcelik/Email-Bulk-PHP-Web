<!-- Code by Ferhat OZCELIK -->
<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: index.php");
  die();
}
require 'config.php';
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <title>Multi Email Sender</title>
  <!-- Meta tag Keywords -->
  <meta charset="UTF-8">
  <meta name="description" content="Free Web tutorials">
  <meta name="keywords" content="Multi Email Sender">
  <meta name="author" content="Ferhat ÖZÇELİK">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- //Meta tag Keywords -->
  <!--/Style-CSS -->
  <link rel="stylesheet" href="css/bulk_email_style.css" type="text/css" media="all" />
  <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <!--//Style-CSS -->
  <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>
  <div class="wrapper">
    <div id="alert"></div>
    <form class="form" id="form">
      <a href='logout.php' class="my-btn" style="width: 100%; margin: 8px">
        Logout
      </a>
      <a href='emaillist.php' class="my-btn" style="width: 100%; margin: 8px">
        Email List
      </a>
      <a href='home-list.php' class="my-btn" style="width: 100%; margin: 8px">
        Multi Email Send
      </a>

      <div class="input-box">
        <input type="text" name="name" placeholder="Name" class="input" value=<?= $ConfigName ?> required />
      </div>
      <div class="input-box">
        <input type="email" name="from" placeholder="From: (Email)" class="input" value=<?= $ConfigEmail ?> required />
      </div>
      <div class="multiple-fields" id="multipleFields">
        <div class="input-box">
          <input type="email" name="to[]" placeholder="To: (Email)" class="input first" required="">
          <button type="button" id="addMore" class="my-btn btn-sm">
            Add More
          </button>
        </div>
      </div>
      <div class="input-box">
        <input type="text" name="reply-to" placeholder="Reply-to: (Optional)" class="input" />
      </div>
      <div class="input-box">
        <input type="text" name="subject" placeholder="Subject:" class="input" required />
      </div>
      <div class="input-box">
        <textarea class="input" name="msg" placeholder="Message"></textarea>
      </div>
      <div class="input-box">
        <input type="file" name="file[]" class="input" multiple />
      </div>
      <button type="submit" name="send-email" class="my-btn" style="width: 100%; margin-top: 10px">
        Send Mail
      </button>
    </form>
    <img src="images/loader.gif" alt="" id="loader" class="loader" />
  </div>
  <footer class="footer">
    <p>by Developed <a href="https://ferhatozcelik.com">Ferhat ÖZÇELİK</a>
    </p>
  </footer>
  <!-- jQuery -->
  <script src="js/jquery.min.js"></script>
  <!-- App.js -->
  <script src="js/app.js"></script>
</body>

</html>