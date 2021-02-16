<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['class_id'])) {
  $class_id = $_GET['class_id'];
  $_SESSION['class_id'] = $class_id;

  $getModulesPerClass = new Settings();
  $modules = $getModulesPerClass->getModulesPerClass($class_id);

  $getClassName = new Teacher();
  $class_name = $getClassName->getClassName($class_id);

}

if (isset($_SESSION['class_id'])) {
  $class_id = $_SESSION['class_id'];
  $_SESSION['class_id'] = $class_id;

  $getModulesPerClass = new Settings();
  $modules = $getModulesPerClass->getModulesPerClass($class_id);

  $getClassName = new Teacher();
  $class_name = $getClassName->getClassName($class_id);
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['add_module'])) {
  $class_id = $_POST['class_id'];
  $module = $_POST['module'];

  $addModule = new Settings();
  $addModule = $addModule->addModule($class_id, $module);

}

if (isset(($_GET['delete']))) {
  $module_id = $_GET['delete'];
  $class_id = $_GET['class_id'];

  $deleteModule = new Settings();
  $modules = $deleteModule->deleteModule($class_id, $module_id);

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

  <title><?php if(isset($_GET['class_id'])){ echo $class_name['name'];} ?> Modules | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Modules</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Modules in <?php if(isset($_GET['class_id'])){ echo $class_name['name'];} ?> Class</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
<i class="fas fa-plus"></i> Add New Module
</button>
<br><br>
  <!-- Basic Card Example -->
    <div class="card border-primary shadow mb-4">
      <div class="card-body">
      <?php
      if(isset($_SESSION["module_added"]) && $_SESSION["module_added"]==true)
            { ?>
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong> New Module Added Successfully
      </div>  <?php
      unset($_SESSION["module_added"]);
      $page = "view-modules.php?id=".$class_id;
      $page=$_SERVER['REQUEST_URI'];
      header("Refresh: 4; URL=$page");
                }
        ?>

      <?php
      if(isset($_SESSION["module_deleted"]) && $_SESSION["module_deleted"]==true)
            { ?>
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong> Module Deleted Successfully
      </div>  <?php
      unset($_SESSION["module_deleted"]);
      $page1 = "view-modules.php?id=".$class_id;
      $page=$_SERVER['REQUEST_URI'];
      header("Refresh: 4; URL=$page1");
                }
        ?>
    <p style="color: blue;">These are all the modules in <?php if(isset($_GET['class_id'])){ echo $class_name['name'];} ?> class</p>
    <?php
      if(isset($modules) && count($modules)>0){
        foreach($modules as $module){ ?>
      <h2><span class="badge badge-secondary"> <?php echo $module['name']; ?></span> <a href="view-modules.php?delete=<?php echo $module['id']; ?>&class_id=<?php if(isset($_GET['class_id'])){ echo $_GET['class_id'];} ?>"><i class="fas fa-trash" style="color: red;"></i></a></h2>
            <?php 
          }
        }
      ?>

      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-5">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 28rem;" src="../images/undraw_settings_ii2j.svg" alt="">
  </div>
</div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Module</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="view-modules.php?class_id=<?php if(isset($_GET['class_id'])){ echo $_GET['class_id'];} ?>" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">Module Name</label>
          <input type="text" name="module" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter class name">
          <small id="emailHelp" class="form-text text-muted">This module will be available to this class only</small>
          <input type="hidden" name="class_id" value="<?php if(isset($_GET['class_id'])){ echo $_GET['class_id'];} ?>">
        </div>
      <button type="submit" name="add_module" class="btn btn-outline-primary"><i style="font-size: 18px;" class="fas fa-plus"></i> Add Module</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Main Content -->
<style type="text/css">
  label{color: black;}
</style>

<?php include 'footer.php';  ?>