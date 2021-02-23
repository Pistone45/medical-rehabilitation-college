<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_SESSION['year'])) {
  $year = $_SESSION['year'];
  $semester_id = $_SESSION['semester_id'];

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

  <title>Your Grades | MRC</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
    <li class="breadcrumb-item active" aria-current="page">Your Grades</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Viewing Your Grades <?php echo $_SESSION['user']['username']; ?></h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-9">

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
        header('URL= filter-view-grades.php');
                  }
          ?>
        <div class="table-responsive">
        <?php
        if(isset($grades) && count($grades)>0){
        $i = 0; 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Class Name</th>
                      <th>Module</th>
                      <th>Grade</th>
                      <th>Comment</th>
                      <th>Date Recorded</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($grades as $grade){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $grade['class_name']; ?></td>
                      <td><?php echo $grade['module_name']; ?></td>
                      <td><?php echo $grade['grade'];
                      if($grade['grade'] > 0 && $grade['grade'] < 40 ){ ?> <b style="color: red">(Fail)</b> <?php 
                    }else{ ?> <b style="color: green">(Pass)</b> <?php } ?></td>
                      <td><?php echo $grade['comments']; ?>
                      <td><?php $date = date_create($grade['date_recorded']); echo date_format($date,"d, M Y"); ?></td>
                    </tr>

          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                         
                          ?> <a href="filter-grades.php"> <button class="btn btn-primary">Back <i style="font-size: 18px;" class="fas fa-undo"></i></button></a>
                          <div align="center">
                          <p>No Grades Available for Your Class and Module</p>
                          <i style="font-size: 90px;" class="far fa-meh-blank"></i>
                          </div> 
                          <?php
                      }
        ?>

              </div>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-3">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../images/undraw_detailed_analysis_xn7y.svg" alt="">
  </div>
</div>

      </div>
      <!-- End of Main Content -->
<?php include 'footer.php';  ?>