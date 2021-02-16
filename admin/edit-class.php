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

if (isset($_GET['id'])) {
$id = $_GET['id'];

$getSpecificStudentClass = new Students();
$specific_class = $getSpecificStudentClass->getSpecificStudentClass($id);

$getClasses = new Settings();
$all_classes = $getClasses->getClasses();

}


if (isset($_POST['change_class'])) {
$class_id = $_POST['class_id'];
$student_no = $_POST['student_no'];

$updateStudentClass = new Students();
$updateStudentClass = $updateStudentClass->updateStudentClass($class_id, $student_no);

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

  <title>Edit Class | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Edit Class</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Edit <?php if(isset($_GET['id'])) {echo $specific_class['student_name'];} ?>'s Class</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">
  <!-- Basic Card Example -->
    <div class="card border-primary shadow mb-4">
      <div class="card-body">
      <?php
      if(isset($_SESSION["class_updated"]) && $_SESSION["class_updated"]==true)
            { ?>
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong>Student Class Changed Successfully
      </div>  <?php
      unset($_SESSION["class_updated"]);
      header('Refresh: 4; URL= view-students.php');
                }
        ?>

    <p style="color: blue;">Change Class Below:</p>
  <ul class="list-group list-group-flush">
<form action="edit-class.php" method="POST">
  <input type="hidden" name="student_no" value="<?php if(isset($_GET['id'])){ echo $_GET['id'];} ?>">
<select name="class_id" class="custom-select">
  <option value="<?php if(isset($_GET['id'])) {echo $specific_class['classes_id'];} ?>" selected><?php if(isset($_GET['id'])) { echo $specific_class['name'];} ?></option>
      <?php
      if(isset($all_classes) && count($all_classes)>0){
        foreach($all_classes as $classes){ ?>
            <option value="<?php echo $classes['id']; ?>"><?php echo $classes['name']; ?></option>
            <?php 
          }
        }
      ?>

</select>
<br><br>
<button type="submit" name="change_class" class="btn btn-primary"><i class="fas fa-edit"></i> Change Class</button>
</form>
  </ul>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-5">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 28rem;" src="../images/undraw_youtube_tutorial_2gn3.svg" alt="">
  </div>
</div>

</div>

<!-- End of Main Content -->
<style type="text/css">
  label{color: black;}
</style>

<?php include 'footer.php';  ?>