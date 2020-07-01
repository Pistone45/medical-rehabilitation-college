<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['filter'])) {
  $class_id = $_POST['class_id'];
  $modules_id = $_POST['modules_id'];
  $getStudentsGradesPerClass = new Teacher();
  $students = $getStudentsGradesPerClass->getStudentsGradesPerClass($class_id, $modules_id);

  $getModuleName = new Teacher();
  $module = $getModuleName->getModuleName($modules_id);

  $getClassName = new Teacher();
  $class = $getClassName->getClassName($class_id);

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
          <h1 class="h3 mb-4 text-gray-800">Viewing <?php echo $class['name']; ?>'s <?php echo $module['name']; ?> Grades  </h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-1"></div>
  <div class="col-md-10">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
        <?php
        if(isset($students) && count($students)>0){
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
                      <th>Date Recorded</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($students as $student){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $student['student_no']; ?></td>
                      <td><?php echo $student['name']; ?></td>
                      <td><?php echo $module['name']; ?></td>
                      <td><?php echo $student['class_name']; ?></td>
                      <td><?php echo $student['grade']; ?></td>
                      <td><?php $date = date_create($student['date_recorded']); echo date_format($date,"d, M Y"); ?></td>
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
  <div class="col-md-1"></div>
</div>

      </div>
      <!-- End of Main Content -->
<?php include 'footer.php';  ?>