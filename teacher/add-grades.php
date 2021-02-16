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
  $_SESSION['year'] = $_POST['year'];
  $_SESSION['semester_id'] = $_POST['semester_id'];

  $getStudentsPerClass = new Teacher();
  $students = $getStudentsPerClass->getStudentsPerClass($class_id);

  $getModuleName = new Teacher();
  $module = $getModuleName->getModuleName($modules_id);
}

if (isset($_POST['record'])) {
$grade = $_POST['grade'];
$student_no = $_POST['student_no'];
$class_id = $_POST['class_id'];
$modules_id = $_POST['modules_id'];
$year = $_SESSION['year'];
$semester_id = $_SESSION['semester_id'];
$modules_id = $_POST['modules_id'];

$recordGrade = new Teacher();
$recordGrade = $recordGrade->recordGrade($grade, $student_no, $class_id, $year, $semester_id, $modules_id);

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

  <title>Record Grades | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Record Grades</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Record Grades</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-0"></div>
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
          <?php
            if(isset($_SESSION["grade_recorded"]) && $_SESSION["grade_recorded"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have Successfully recorded a Grade for This Class and Module
            </div>  <?php
            unset($_SESSION["grade_recorded"]);
            header('Refresh: 5; URL= filter-view-grades.php');
                      }
              ?>
            <?php
            if(isset($_SESSION["grade_present"]) && $_SESSION["grade_present"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Failed! </strong> You have Already recorded a Grade for This Class and Module
            </div>  <?php
            unset($_SESSION["grade_present"]);
            header('Refresh: 5; URL= filter-grades.php');
                      }
              ?>
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
                      <form action="add-grades.php" method="POST">
                      <td>
              <div class="form-group">
                <input type="number" min="0" max="100" name="grade[]"  class="form-control" id="formGroupExampleInput" placeholder="Enter Grade" required="">
              </div>
              <input type="text" hidden="" name="student_no[]" class="form-control" value="<?php echo $student['student_no']; ?>">
                      </td>
                    </tr>

          <?php
            
          } ?>

                  </tbody>
                </table>
  <input type="text" hidden="" name="modules_id" class="form-control" value="<?php if(isset($_POST['modules_id'])){ echo $modules_id = $_POST['modules_id'];} ?>">
  <input type="text" hidden="" name="class_id" class="form-control" value="<?php if(isset($_POST['class_id'])){ echo $class_id = $_POST['class_id'];} ?>">
  <button type="submit" name="record" class="btn btn-primary btn-block"><i class="far fa-clipboard"></i> Record Grades</button>
  </form>
                <?php
                      }else {
                        echo "No Students Available for this Class "; 
                          ?> <a href="filter-grades.php"> <button class="btn btn-outline-primary">Back <i style="font-size: 18px;" class="fas fa-undo"></i></button></a> <?php
                      }
        ?>

              </div>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-0"></div>
</div>

</div>
<!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; MRC College <?php echo DATE('Y'); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="../functions/logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->


</body>

</html>