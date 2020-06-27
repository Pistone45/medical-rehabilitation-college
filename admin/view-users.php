<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();


$getStudents = new Students();
$students = $getStudents->getStudents();

$getTeachers = new Staff();
$teachers = $getTeachers->getTeachers();

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

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
    <li class="breadcrumb-item active" aria-current="page">View Users</li>
  </ol>
</nav>

        <!-- End of Topbar -->   <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">Student</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu1">Teacher</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane container active" id="home">
    <br>
    <!-- Add Student Card -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Student Table</h6>
      </div>
            <?php
            if(isset($_SESSION["student_found"]) && $_SESSION["student_found"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Student Already Exist! </strong> Student is present in the system
            </div>  <?php
            unset($_SESSION["student_found"]);
                      }
              ?>
            <?php
            if(isset($_SESSION["student-added"]) && $_SESSION["student-added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Student Added Successfully
            </div>  <?php
            unset($_SESSION["student-added"]);
            header('Refresh: 5; URL= view-users.php');
                      }
              ?>
      <div class="card-body">
          <div class="row container-fluid">
            <div class="col-md-12 col-xs-12">
              
              <div class="table-responsive">
        <?php
        if(isset($students) && count($students)>0){ 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Date of Birth</th>
                      <th>Gender</th>
                      <th>Nationality</th>
                      <th>Email</th>
                      <th>Date Added</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($students as $student){ 
          ?>
                    <tr>
                      <td><?php echo $student['name']; ?></td>
                      <td><?php echo $student['dob']; ?></td>
                      <td><?php echo $student['gender']; ?></td>
                      <td><?php echo $student['nationality']; ?></td>
                      <td><?php echo $student['email']; ?></td>
                      <td><?php echo $student['date_added']; ?></td>
                      <td><?php if($student['status'] == 1){  ?><div class="custom-control custom-switch">
  <input type="checkbox" checked="" class="custom-control-input" id="customSwitch1">
  <label class="custom-control-label" for="customSwitch1"><a href="#">Disable</a></label></div><?php  }else{  ?><div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="customSwitch1">
  <label class="custom-control-label" for="customSwitch1"><a href="#">Enable</a></label></div><?php } ?></td>
                    </tr>
          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                        echo "No Students Available";
                      }
        ?>
              </div>

            </div>
          </div>
      </div>
    </div>
    <!--End of Student Card -->
  
  </div>
  <div class="tab-pane container fade" id="menu1">
    <br>
    <!-- Add Teacher Card -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Teacher Table</h6>
      </div>
      <?php
            if(isset($_SESSION["teacher-found"]) && $_SESSION["teacher-found"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Teacher Already Exist! </strong> Teacher is present in the system
            </div>  <?php
            unset($_SESSION["teacher-found"]);
                      }
              ?>
            <?php
            if(isset($_SESSION["teacher-added"]) && $_SESSION["teacher-added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Teacher Added Successfully
            </div>  <?php
            unset($_SESSION["teacher-added"]);
            header('Refresh: 5; URL= view-users.php');
                      }
              ?>
      <div class="card-body">
                  <div class="row container-fluid">
            <div class="col-md-12 col-xs-12">
              
              <div class="table-responsive">
        <?php
        if(isset($teachers) && count($teachers)>0){ 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Gender</th>
                      <th>Nationality</th>
                      <th>Email</th>
                      <th>Qualification</th>
                      <th>Experience</th>
                      <th>Date Added</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php

          foreach($teachers as $teacher){ 
          ?>
                    <tr>
                      <td><?php echo $teacher['name']; ?></td>
                      <td><?php echo $teacher['gender']; ?></td>
                      <td><?php echo $teacher['nationality']; ?></td>
                      <td><?php echo $teacher['email']; ?></td>
                      <td><?php echo $teacher['qualification']; ?></td>
                      <td><?php echo $teacher['experience']; ?></td>
                      <td><?php echo $teacher['date_added']; ?></td>
                      <td><i class="fas fa-trash"></i> <a href="delete-teacher.php">Delete</a></td>
                    </tr>
          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                        echo "No Teachers Available";
                      }
        ?>
              </div>

            </div>
          </div>
      </div>
    </div>
    <!--End of Teacher Card -->
    
  </div>
</div>

</div>



      </div>
      <!-- End of Main Content -->
  <script type="text/javascript">
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
  </script>

     <?php include 'footer.php';  ?>