<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getAllMessages = new Staff();
$messages = $getAllMessages->getAllMessages();


if (isset($_POST['mark'])) {
$id = $_POST['id'];
$markNotificationRead = new Students();
$markNotificationRead = $markNotificationRead->markNotificationRead($id);

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

  <title>Messages | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Messages</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">All Sent Messages <a href="view-students.php"><button class="btn btn-outline-primary">Send Message</button></a></h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-9">
  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <?php
        if(isset($_SESSION["notification_sent"]) && $_SESSION["notification_sent"]==true)
              { ?>
        <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success! </strong> Notification to all Students sent
        </div>  <?php
        unset($_SESSION["notification_sent"]);
        header('Refresh: 4; URL= view-notifications.php');
                  }
          ?>
        <?php
        if(isset($_SESSION["notification_read"]) && $_SESSION["notification_read"]==true)
              { ?>
        <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success! </strong> Notification marked as read
        </div>  <?php
        unset($_SESSION["notification_read"]);
        header('Refresh: 2; URL= notifications.php');
                  }
          ?>
        <div class="table-responsive">
        <?php
        if(isset($messages) && count($messages)>0){
        $i = 0; 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Subject</th>
                      <th>Message</th>
                      <th>Date Sent</th>
                      <th>Student No</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($messages as $message){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $message['subject']; ?></td>
                      <td><?php echo $message['message']; ?></td>
                      <td><?php $date = date_create($message['date_sent']); echo date_format($date,"d, M Y"); ?></td>
                      <td><?php echo $message['student_no']; ?></td>
                      
                    </tr>

          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                         
                          ?>
                          <div align="center">
                          <p>You havent sent any Messages</p>
                          <i style="font-size: 100px;" class="fas fa-envelope"></i>
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
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../images/undraw_message_sent_1030.svg" alt="">
  </div>
</div>

</div>
<!-- End of Main Content -->

<?php include 'footer.php';  ?>