<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getAllClasses = new User();
$classes = $getAllClasses-> getAllClasses();

if (isset($_POST['record'])) {
$balance = $_POST['balance'];
$student_no = $_POST['student_no'];
$remarks = $_POST['remarks'];

$RecordFeesBalance = new Accountant();
$RecordFeesBalance = $RecordFeesBalance->RecordFeesBalance($balance, $student_no, $remarks);

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
          <h1 class="h3 mb-4 text-gray-800">Filter Grades</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
      <form action="view-grades.php" method="POST">
      <label>Select Class</label>
            <select class="custom-select" name="class_id" onchange="showModule(this.value)" id="class_id" required="">
              <option style="color: black;" selected="">Select Class.....</option>
            <?php
              if(isset($classes) && count($classes)>0){
                foreach($classes as $class){ ?>
                  <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php
                  
                }
              }
            ?>
            </select>
      <br><br>
      <label>Select Subject</label>
      <select class="custom-select" name="modules_id" id="module_name" required="">
        <option VALUE="">Select Module</option>  
      </select>
      <br><br>
      <button type="submit" name="filter" class="btn btn-outline-success">Continue <i style="font-size: 18px;" class="fas fa-arrow-circle-right"></i></button>
      </form>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-5">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 28rem;" src="../images/undraw_exams_g4ow.svg" alt="">
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