<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getSemesters = new Settings();
$semesters = $getSemesters->getSemesters();

$getCurrentSettings = new Settings();
$settings = $getCurrentSettings->getCurrentSettings();

$year =(int)$settings['year'];
//from academic_year get the last 10 years
$ten_years = $year-10;
$years =range($year,$ten_years,-1);

if (isset($_POST['filter'])) {
  $year = $_POST['year'];
  $semester_id = $_POST['semester_id'];

  $_SESSION['year'] = $year;
  $_SESSION['semester_id'] = $semester_id;

  $getStudentClass = new Students();
  $class = $getStudentClass-> getStudentClass();
  $classes_id = $class['classes_id'];

  $getAllStudentsGrades = new Students();
  $grades = $getAllStudentsGrades->getAllStudentsGrades($year, $semester_id, $classes_id);

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

  <title>Filter Grades | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Filter Grades</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Filter Your Grades</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <?php
        if(isset($_SESSION["balance_found"]) && $_SESSION["balance_found"]==true)
              { ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Fees Balance Found! </strong> Please settle your Fees Balance first
        </div>  <?php
        unset($_SESSION["balance_found"]);
        //header('URL= filter-view-grades.php');
                  }
          ?>

        <?php
        if(isset($_SESSION["no_balance"]) && $_SESSION["no_balance"]==true)
              { ?>
        <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>No Balance! </strong> Proceed
        </div>  <?php
        unset($_SESSION["no_balance"]);
         header('Refresh: 2; URL= view-grades.php');
                  }
          ?>

      <form action="filter-grades.php" method="POST">
      <label>Select Year</label>
        <select required="" name="year" class="form-control">
           <?php
            if(isset($years) && count($years)>0){
              foreach($years as $year){ ?>
                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
              <?php
                
              }
            }
          ?>
        </select>
      <br>
      <label>Select Semester</label>
        <select required="" name="semester_id" class="form-control">
           <?php
            if(isset($semesters) && count($semesters)>0){
              foreach($semesters as $semester){ ?>
                <option value="<?php echo $semester['id']; ?>"><?php echo $semester['name']; ?></option>
              <?php
                
              }
            }
          ?>
        </select>
      <br><br>
      <button type="submit" name="filter" class="btn btn-outline-success">Continue <i style="font-size: 18px;" class="fas fa-arrow-circle-right"></i></button>
      </form>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-5">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../images/undraw_grades_j6jn.svg" alt="">
  </div>
</div>

</div>
<!-- End of Main Content -->
<style type="text/css">
  label{color: black;}
</style>

<script type="text/javascript">
function showModule(val) {
  // alert(val);
  $.ajax({
  type: "POST",
  url: "filter-results.php",
  data:'class_id='+val,
  success: function(data){
    // alert(data);
    $("#module_name").html(data);
  }
  });
  
}
</script>

<?php include 'footer.php';  ?>