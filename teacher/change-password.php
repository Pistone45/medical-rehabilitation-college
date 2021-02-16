<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['change_password'])) {
  $new_password = $_POST['password'];

  $updatePassword = new User();
  $updatePassword->updatePassword($new_password);

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Change Password | MRC</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

<?php include"side-bar2.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

<?php include 'header.php';  ?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Change Password</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">

<div class="card border-dark mb-3">
  <div class="card-body text-dark">
    <p class="card-text">It looks like this is your first login. Change your password below</p>
  </div>
</div>

        <?php
        if(isset($_SESSION["password_updated"]) && $_SESSION["password_updated"]==true)
              { ?>
        <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success! </strong> You have successfully changed your password, Login to continue
        </div> <?php
        unset($_SESSION["password_updated"]);
         header('Refresh: 2; URL= ../functions/logout.php');
                  }
          ?>

      <form action="change-password.php" method="POST">
      <div class="form-group">
        <label for="exampleInputEmail1">New Password</label>
        <input type="password" name="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Enter New Password">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Comfirm Password</label>
        <input type="password" class="form-control" id="confirm_password" aria-describedby="emailHelp" placeholder="Enter New Password">
      </div>

      <button type="submit" name="change_password" id="submit" class="btn btn-outline-success">Change Password <i style="font-size: 18px;" class="fas fa-exchange"></i></button>
      </form>
      <div align="center" id="message"></div>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-5">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../images/undraw_authentication_fsn5.svg" alt="">
  </div>
</div>

</div>
<!-- End of Main Content -->
<style type="text/css">
  label{color: black;}
</style>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript">
$('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Passwords Matched').css('color', 'green');
  } else 
    $('#message').html('Not Matching').css('color', 'red');
});
</script>

<?php include 'footer.php';  ?>