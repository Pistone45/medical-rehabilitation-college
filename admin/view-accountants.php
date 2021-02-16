<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
  
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getAccountants = new Staff();
$accountants = $getAccountants->getAccountants();

if (isset($_GET['id'])) {
$id = $_GET['id'];
$deleteTeacher = new Staff();
$deleteTeacher = $deleteTeacher->deleteTeacher($id);

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

  <title>View Accountants | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">View Accountants</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">View Accountants</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
          <?php
            if(isset($_SESSION["accountant_deleted"]) && $_SESSION["accountant_deleted"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Accountant Deleted Successfully
            </div>  <?php
            unset($_SESSION["accountant_deleted"]);
            header('Refresh: 4; URL= view-teachers.php');
                      }
              ?>
              <div class="table-responsive">
        <?php
        if(isset($accountants) && count($accountants)>0){ 
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

          foreach($accountants as $accountant){ 
          ?>
                    <tr>
                      <td><?php echo $accountant['name']; ?></td>
                      <td><?php echo $accountant['gender']; ?></td>
                      <td><?php echo $accountant['nationality']; ?></td>
                      <td><?php echo $accountant['email']; ?></td>
                      <td><?php echo $accountant['qualification']; ?></td>
                      <td><?php echo $accountant['experience']; ?> Year(s)</td>
                      <td><?php $date = date_create($accountant['date_added']); echo date_format($date,"d, M Y"); ?></td>
                      <td><i class="fas fa-trash text-gray-800"></i> <a href="#">Delete</a></td>
                    </tr>
          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                        echo "No Accountants Available";  ?> <a href="add-accountant.php"><button class="btn btn-outline-primary">Add Accountant <i class="fas fa-plus"></i></button></a><?php
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