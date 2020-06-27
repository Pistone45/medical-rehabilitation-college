<?php
include_once '../functions/functions.php';
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

<?php include"side-bar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

<?php include 'header.php';  ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Materials</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Add Materials</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-1"></div>
  <div class="col-md-10">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <form>
        <label>Select Class</label>
        <select class="custom-select">
          <option selected>Select Class</option>
          <option value="1">Vipya</option>
          <option value="2">Nyika</option>
        </select>
        <br><br>
        <label>Select Subject</label>
        <select class="custom-select">
          <option selected>Select Subject</option>
          <option value="1">Mathematics</option>
          <option value="2">Biology</option>
          <option value="3">English</option>
        </select>
        <br><br>
        <label>Material</label>
        <input class="form-control" name="grade" type="file" placeholder="Enter Grade">
        <small>PDF format</small>
        <br>
        <button class="btn btn-success">Submit</button>
        </form>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-1"></div>
</div>

      </div>
      <!-- End of Main Content -->
<?php include 'footer.php';  ?>