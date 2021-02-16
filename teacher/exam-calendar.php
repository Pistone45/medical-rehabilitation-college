<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getExamCalendarEntries = new Settings();
$calendars = $getExamCalendarEntries->getExamCalendarEntries();

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Exam Calendar | MCA</title>

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
    <li class="breadcrumb-item active" aria-current="page">Exam Calendar</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Exam Calendar</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
        <?php
        $editModal = 0;
        $deleteModal = 0;
        if(isset($calendars) && count($calendars)>0){ 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Class</th>
                      <th>Module</th>
                      <th>Date</th>
                      <th>Time From</th>
                      <th>Time To</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php

          foreach($calendars as $calendar){ 
            $editModal++;
            $deleteModal++;
          ?>
                    <tr>
                      <td><?php echo $calendar['class']; ?></td>
                      <td><?php echo $calendar['module']; ?></td>
                      <td><?php $date = date_create($calendar['exam_date']); echo date_format($date,"d, M Y"); ?></td>
                      <td><?php $date = date_create($calendar['time_from']); echo date_format($date,"h:i A"); ?></td>
                      <td><?php $date = date_create($calendar['time_to']); echo date_format($date,"h:i A"); ?></td>
                    </tr>

          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                        echo "No Exam Calendar Entries Available";
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