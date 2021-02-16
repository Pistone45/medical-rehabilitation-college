<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getFeesBalancePerStudent = new Students();
$feesBalance = $getFeesBalancePerStudent-> getFeesBalancePerStudent();

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();
$student_no = $user_details['username'];

$getSemesters = new Settings();
$semesters = $getSemesters->getSemesters();

$getSpecificStudent = new Students();
$student = $getSpecificStudent->getSpecificStudent($student_no);

$getCurrentSettings = new Settings();
$settings = $getCurrentSettings->getCurrentSettings();

$year =(int)$settings['year'];
//from academic_year get the last 10 years
$ten_years = $year-10;
$years =range($year,$ten_years,-1);

$getStudentClass = new Students();
$class = $getStudentClass-> getStudentClass();
$class_id = $class['classes_id'];
$classes_id = $class['classes_id'];

$getAllClassModules = new Staff();
$modules = $getAllClassModules->getAllClassModules($class_id);

$getExamCalendarEntriesPerStudentDash = new Settings();
$calendars = $getExamCalendarEntriesPerStudentDash->getExamCalendarEntriesPerStudentDash($classes_id);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Your Information | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Your Information</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Your Information</h1>
          

        </div>
        <!-- /.container-fluid -->
<br>
<div class="container">
    <div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?php if($user_details['picture'] == ''){ echo "../images/avatar.png"; }else{ echo $user_details['picture']; } ?>" alt="Student" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?php echo $student['name']; ?></h4>
                      <p class="text-secondary mb-1"><h5><span class="badge badge-secondary">Class:</span> <?php echo $student['class_name']; ?></h5></p>
                      <p class="text-muted font-size-sm"><?php echo $student['nationality']; ?></p>
                      <a href="filter-grades.php"><button class="btn btn-outline-primary">Grades</button></a>
                      <a href="filter-materials.php"><button class="btn btn-outline-primary">Materials</button></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <h4 style="padding-top: 10px;" align="center"><span class="badge badge-secondary">Overview</span></h4>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i style="font-size: 30px;" class="fas fa-calendar-week"></i> <span style="font-size: 22px;">Year</span></h6>
                    <span class="text-secondary"><?php echo $settings['year']; ?></span>
                  </li>
                  
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i style="font-size: 30px;" class="fas fa-university"></i> <span style="font-size: 22px;">Semester</span></h6>
                    <span class="text-secondary"><?php echo $settings['semester_name']; ?></span>
                  </li>                  

                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i style="font-size: 28px;" class="fas fa-money-bill-wave"></i> <span style="font-size: 22px;">Fees Balance</span></h6>
                    <span class="text-secondary"> <?php if($feesBalance['balance'] == 0){ echo "No Balance"; }else{ echo "K"; echo number_format($feesBalance['balance']); } ?></span>
                  </li> 

                </ul>
              </div>
            </div>

            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Student Number</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $student['student_no']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $student['name']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $student['email']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $student['phone']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Class</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $student['class_name']; ?>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Date of Birth</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php
                      $date = date_create($student['dob']);
                      echo date_format($date,"d, M Y");
                      ?>
                    </div>
                  </div>

                </div>
              </div>
              <div class="row gutters-sm">
                <div class="col-sm-5 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h4 style="padding-top: 0px;" align="center"><span class="badge badge-secondary">Your Subjects</span></h4>

            <?php
            if(isset($modules) && count($modules)>0){
              foreach($modules as $module){ ?>
                      <small><?php echo $module['module_name']; ?></small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                  <?php
                    
                  }
                }
              ?>

                    </div>
                  </div>
                </div>
                <div class="col-sm-7 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <h4 style="padding-top: 0px;" align="center"><span class="badge badge-secondary">Exams</span></h4>
            <?php
            if(isset($calendars) && count($calendars)>0){
              foreach($calendars as $calendar){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                      You have <strong><a href="exam-calendar.php"><?php echo $calendar['module']; ?></a></strong> on <?php $date = date_create($calendar['exam_date']); echo date_format($date,"d, M Y"); ?>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php
                    
                  }
                }
              ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

</div>
<!-- End of Main Content -->
<?php include 'footer.php';  ?>