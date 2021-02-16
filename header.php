<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MRC</title>
  <meta name="description" content="Medical Rehabilitation College Website">
  <meta name="keywords" content="HTML,CSS,XML,JavaScript, Php">
  <meta name="author" content="Medical Rehabilitation College">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo"><a href="index.php">MRC</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav class="nav-menu d-none d-lg-block">

<?php
switch ($page) {
    case "1":
          ?>
          <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="anouncements.php">Anouncements</a></li>
          <li><a href="our-team.php">Our Team</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
        <?php
        break;

    case "2":
          ?>
          <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="anouncements.php">Anouncements</a></li>
          <li><a href="our-team.php">Our Team</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
        <?php
        break;

    case "3":
          ?>
          <ul>
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="anouncements.php">Anouncements</a></li>
          <li><a href="our-team.php">Our Team</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
        <?php
        break;

    case "4":
          ?>
          <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="anouncements.php">Anouncements</a></li>
          <li class="active"><a href="our-team.php">Our Team</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
        <?php
        break;

    case "5":
          ?>
          <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="anouncements.php">Anouncements</a></li>
          <li><a href="our-team.php">Our Team</a></li>
          <li class="active"><a href="contact-us.php">Contact Us</a></li>
        </ul>
        <?php
        break;

    default:
          ?>
          <ul>
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="anouncements.php">Anouncements</a></li>
          <li><a href="our-team.php">Our Team</a></li>
          <li><a href="contact-us.php">Contact Us</a></li>
        </ul>
        <?php
}
?>

      </nav><!-- .nav-menu -->

      <a href="login.php" class="get-started-btn ml-auto">Login</a>

    </div>
  </header><!-- End Header -->