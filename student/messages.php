<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getMessagesPerStudent = new Students();
$messages = $getMessagesPerStudent->getMessagesPerStudent();


if (isset($_POST['mark'])) {
$id = $_POST['id'];
$markMessageRead = new Students();
$markMessageRead = $markMessageRead->markMessageRead($id);

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
          <h1 class="h3 mb-4 text-gray-800">All Messages <i class="far fa-envelope-open"></i></h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-9">
  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <?php
        if(isset($_SESSION["message_read"]) && $_SESSION["message_read"]==true)
              { ?>
        <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success! </strong> Message marked as read
        </div>  <?php
        unset($_SESSION["message_read"]);
        header('Refresh: 2; URL= messages.php');
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
                      <th>Mark Read</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($messages as $message){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo substr($message['subject'],0, 90); ?>....</td>
                      <td><?php echo substr($message['message'],0, 120); ?>...<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#more<?php echo $i; ?>modal">More</button></td>
                      <td><?php $date = date_create($message['date_sent']); echo date_format($date,"d, M Y"); ?></td>
                      <td><?php if($message['status'] == 0){  ?><form action="messages.php" method="POST">
                      <input type="text" hidden="" name="id" value="<?php echo $message['id']; ?>">
                      <button name="mark" type="submit" class="btn btn-outline-success"><i class="far fa-envelope-open"></button></i>
                      </form><?php }else{  ?><form action="#" method="POST">
                      <input type="text" hidden="" name="id" value="<?php echo $message['id']; ?>">
                      <button name="mark" type="submit" disabled="" class="btn btn-success"><i class="far fa-envelope-open"></button></i>
                      </form><?php } ?></td>
                      
                    </tr>

                    <!-- Modal -->
<div class="modal fade" id="more<?php echo $i; ?>modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Read More</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5><?php echo $message['subject']; ?></h5>
        <div class="card card-body bg-light">
             <?php echo $message['message']; ?>
        </div>
        <i class="far fa-calendar-minus"></i> <?php $date = date_create($message['date_sent']); echo date_format($date,"d, M Y"); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="messages.php" method="POST">
          <input type="text" hidden="" name="id" value="<?php echo $message['id']; ?>">
          <?php if($message['status'] == 0){  ?><button type="submit" name="mark" class="btn btn-primary">Mark Read</button><?php  }else{} ?>
        </form>
      </div>
    </div>
  </div>
</div>

          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                         
                          ?>
                          <div align="center">
                          <p>You don't have any Messages</p>
                          <i style="font-size: 90px;" class="fas fa-envelope"></i>
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
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../images/undraw_mail_box_kd5i (1).svg" alt="">
  </div>
</div>

<style>
.btn-group-xs > .btn, .btn-xs {
  padding: .30rem .4rem;
  font-size: .875rem;
  line-height: .5;
  border-radius: .3rem;
}
</style>
</div>
<!-- End of Main Content -->

<?php include 'footer.php';  ?>