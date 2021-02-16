<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['filter'])) {
  $year = $_POST['year'];
  $modules_id = $_POST['modules_id'];
  $class_id = $_POST['class_id'];
  $semester_id = $_POST['semester_id'];

  $_SESSION['year'] = $year;
  $_SESSION['modules_id'] = $modules_id;
  $_SESSION['class_id'] = $class_id;
  $_SESSION['semester_id'] = $semester_id;

  $getModuleName = new Teacher();
  $module = $getModuleName->getModuleName($modules_id);

  $getClassName = new Teacher();
  $class = $getClassName->getClassName($class_id);

  $getAllGrades = new Students();
  $grades = $getAllGrades->getAllGrades($year, $modules_id, $class_id, $semester_id);

}else{

  $year = $_SESSION['year'];
  $modules_id = $_SESSION['modules_id'];
  $class_id = $_SESSION['class_id'];
  $semester_id = $_SESSION['semester_id'];

  $getModuleName = new Teacher();
  $module = $getModuleName->getModuleName($modules_id);

  $getClassName = new Teacher();
  $class = $getClassName->getClassName($class_id);

  $getAllGrades = new Students();
  $grades = $getAllGrades->getAllGrades($year, $modules_id, $class_id, $semester_id);
}

if (isset($_POST['edit_grade'])) {
  $student_no = $_POST['student_no'];
  $grade = $_POST['grade'];
  $grade_id = $_POST['grade_id'];

  $adminUpdateGrades = new Students();
  $adminUpdateGrades->adminUpdateGrades($student_no, $grade, $grade_id);
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

  <title>View Grades | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">View Grades</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $_SESSION['year']; ?> <?php if($_SESSION['semester_id'] == 1){ echo "First Semester";  }else{ echo "Second Semester"; } ?> <?php echo $class['name']; ?> <?php echo $module['name']; ?> Grades  </h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">

      <?php
      if(isset($_SESSION["grade_updated"]) && $_SESSION["grade_updated"]==true)
            { ?>
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong> Grade updated Successfully
      </div>  <?php
      unset($_SESSION["grade_updated"]);
      header('Refresh: 4; URL= view-grades.php');
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
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Module</th>
                      <th>Class</th>
                      <th>Grade</th>
                      <th>Year</th>
                      <th>Semester</th>
                      <th>Date Recorded</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($grades as $grade){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $grade['student_no']; ?></td>
                      <td><?php echo $grade['student_name']; ?></td>
                      <td><?php echo $grade['module_name']; ?></td>
                      <td><?php echo $grade['class_name']; ?></td>
                      <td><?php echo $grade['grade']; ?></td>
                      <td><?php echo $grade['year']; ?></td>
                      <td><?php echo $grade['semester']; ?></td>
                      <td><?php $date = date_create($grade['date_recorded']); echo date_format($date,"d, M Y"); ?></td>
                    </tr>

          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                        echo "No Grades Available for this Class and Module"; 
                          ?> <a href="filter-view-grades.php"> <button class="btn btn-outline-primary">Back <i style="font-size: 18px;" class="fas fa-undo"></i></button></a> <?php
                      }
        ?>

              </div>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
</div>

      </div>
      <!-- End of Main Content -->
<?php include 'footer.php';  ?>