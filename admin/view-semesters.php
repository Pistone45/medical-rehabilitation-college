<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
$getSemesters = new Settings();
$semesters = $getSemesters->getSemesters();

$getCurrentSettings = new Settings();
$settings = $getCurrentSettings->getCurrentSettings();

$year =(int)$settings['year'];
//from academic_year get the last 10 years
$ten_years = $year+10;
$years =range($year,$ten_years,-1);

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['add'])) {
  $getCurrentSettings = new Settings();
  $settings = $getCurrentSettings-> getCurrentSettings();
  $old_id = $settings['id'];
  $old_year = $settings['year'];
  $old_semester_id = $settings['semester_id'];

  $year = $_POST['year'];
  $semester_id = $_POST['semester_id'];

  $updateCurrentSettings = new Settings();
  $updateCurrentSettings = $updateCurrentSettings->updateCurrentSettings($old_id, $old_year, $old_semester_id, $year, $semester_id);

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

  <title>Current Settings | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Current Settings</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Current Settings</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
<i class="fas fa-plus"></i> Add New Settings
</button>
<br><br>
  <!-- Basic Card Example -->
    <div class="card border-primary shadow mb-4">
      <div class="card-body">
      <?php
      if(isset($_SESSION["settings_updated"]) && $_SESSION["settings_updated"]==true)
            { ?>
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong> New Semester and Year Added Successfully
      </div>  <?php
      unset($_SESSION["settings_updated"]);
      header('Refresh: 4; URL= view-semesters.php');
                }
        ?>

      <h6 class="m-0 font-weight-bold text-primary">Below is the current Year and Semester</h6>
      <br>
      <h2><i class="fas fa-calendar-week"></i> Year: <span class="badge badge-secondary"> <?php echo $settings['year']; ?></span></h2> 
      <br>
      <h2><i class="fas fa-university"></i> Semester: <span class="badge badge-secondary"> <?php echo $settings['semester_name']; ?></span></h2>
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
        <h5 class="modal-title" id="exampleModalLabel">Add New Year and Semester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="view-semesters.php" method="POST">
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
      <br>
      <button type="submit" name="add" class="btn btn-outline-primary"><i style="font-size: 18px;" class="fas fa-plus"></i> Add Settings</button>
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