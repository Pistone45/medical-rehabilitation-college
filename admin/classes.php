<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
$getClasses = new Settings();
$classes = $getClasses->getClasses();


$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['add_class'])) {

  $class = $_POST['class'];

  $addClass = new Settings();
  $addClass = $addClass->addClass($class);

}

if (isset(($_GET['delete']))) {
  $class_id = $_GET['delete'];

  $deleteClass = new Settings();
  $class = $deleteClass->deleteClass($class_id);

}

unset($_SESSION["class_id"]);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Classes | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Classes</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">All Classes</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
<i class="fas fa-plus"></i> Add New Class
</button>
<br><br>
  <!-- Basic Card Example -->
    <div class="card border-primary shadow mb-4">
      <div class="card-body">
      <?php
      if(isset($_SESSION["class_added"]) && $_SESSION["class_added"]==true)
            { ?>
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong> New Class Added Successfully
      </div>  <?php
      unset($_SESSION["class_added"]);
      header('Refresh: 4; URL= classes.php');
                }
        ?>

      <?php
      if(isset($_SESSION["class_deleted"]) && $_SESSION["class_deleted"]==true)
            { ?>
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong> Class Deleted Successfully
      </div>  <?php
      unset($_SESSION["class_deleted"]);
      header('Refresh: 4; URL= classes.php');
                }
        ?>

      <?php
      if(isset($_SESSION["class_has_students"]) && $_SESSION["class_has_students"]==true)
            { ?>
      <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Failed! </strong> The class has students. Go to view students and remove each from the class or Remove Modules from the class
      </div>  <?php
      unset($_SESSION["class_has_students"]);
      header('Refresh: 5; URL= classes.php');
                }
        ?>

    <p style="color: blue;">Click a class to view it's subjects</p>
  <ul class="list-group list-group-flush">
      <?php
      if(isset($classes) && count($classes)>0){
        foreach($classes as $class){ ?>
      <li class="list-group-item">
      <h2><a href="view-modules.php?class_id=<?php echo $class['id']; ?>"><span class="badge badge-secondary"> <?php echo $class['name']; ?></span></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="classes.php?delete=<?php echo $class['id']; ?>"><i class="fas fa-trash" style="color:;"></i></a></h2>
      </li>
            <?php 
          }
        }
      ?>
  </ul>
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
        <h5 class="modal-title" id="exampleModalLabel">Add New Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="classes.php" method="POST">
        <div class="form-group">
          <label for="exampleInputEmail1">Class Name</label>
          <input type="text" name="class" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter class name">
          <small id="emailHelp" class="form-text text-muted">Every class will have subjects</small>
        </div>
      <button type="submit" name="add_class" class="btn btn-outline-primary"><i style="font-size: 18px;" class="fas fa-plus"></i> Add Class</button>
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