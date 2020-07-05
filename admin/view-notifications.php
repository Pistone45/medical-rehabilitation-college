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

$getAllNotifications = new Staff();
$notifications = $getAllNotifications->getAllNotifications();

if (isset($_POST['send'])) {
  $notification = $_POST['notification'];
  $student_no = $_POST['student_no'];

  $sendNotification = new Staff();
  $sendNotification = $sendNotification->sendNotification($notification, $student_no);

}

if (isset($_POST['delete'])) {
$notification = $_POST['notification'];
$deleteNotification = new Staff();
$deleteNotification = $deleteNotification->deleteNotification($notification);

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

  <title>Notifications | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Send/View Notifications</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-8">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Send Notification
</button>
<br><br>
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
        if(isset($_SESSION["failed"]) && $_SESSION["failed"]==true)
              { ?>
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Failed! </strong> Failed to Send, Please add students or Contact Admin
        </div>  <?php
        unset($_SESSION["failed"]);
        header('Refresh: 4; URL= view-notifications.php');
                  }
          ?>
        <?php
        if(isset($_SESSION["notification_deleted"]) && $_SESSION["notification_deleted"]==true)
              { ?>
        <div class="alert alert-warning" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success! </strong> Notification Deleted Successfully
        </div>  <?php
        unset($_SESSION["notification_deleted"]);
        header('Refresh: 4; URL= view-notifications.php');
                  }
          ?>
        <div class="table-responsive">
        <?php
        if(isset($notifications) && count($notifications)>0){
        $i = 0; 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Notification</th>
                      <th>Date Sent</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($notifications as $notification){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $notification['notification']; ?></td>
                      <td><?php $date = date_create($notification['date_sent']); echo date_format($date,"d, M Y"); ?></td>
                      <td>
                      <form action="view-notifications.php" method="POST">
                      <input type="text" hidden="" name="notification" value="<?php echo $notification['notification']; ?>">
                      <button name="delete" type="submit" class="btn btn-danger"><i class="fas fa-trash"></button></i>
                      </form>
                      </td>
                    </tr>

          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                         
                          ?>
                          <div align="center">
                          <p>You havent sent a Notification, Send one</p>
                          <i style="font-size: 100px;" class="fas fa-bell"></i>
                          </div> 
                          <?php
                      }
        ?>

              </div>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-4">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../images/undraw_envelope_n8lc.svg" alt="">
  </div>
</div>

</div>
<!-- End of Main Content -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Notification to Students <i class="fas fa-bell"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="view-notifications.php" method="POST">
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Notification</label>
        <textarea name="notification" class="form-control" id="exampleFormControlTextarea1" placeholder="Enter Notification" rows="3"></textarea>
      </div>
        <?php
        if(isset($students) && count($students)>0){ 
         foreach($students as $student){  ?>
      <input type="text" hidden="" name="student_no[]" value="<?php echo $student['student_no']?>">
                <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                        
                      }
        ?>

      <button class="btn btn-primary" type="submit" name="send"><i class="fas fa-envelope-open-text"></i> Send Notification</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php';  ?>