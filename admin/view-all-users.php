<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
  
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getAllUsers = new User();
$users = $getAllUsers->getAllUsers();

if (isset($_GET['enable_id'])) {
$id = $_GET['enable_id'];
$enableUser = new User();
$enableUser = $enableUser->enableUser($id);

}

if (isset($_GET['disable_id'])) {
$id = $_GET['disable_id'];
$disableUser = new User();
$disableUser = $disableUser->disableUser($id);

}

if (isset($_POST['change_password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $changePassword = new User();
  $changePassword = $changePassword->changePassword($username, $password);  

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

  <title>View Users | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">View Users</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Users of the System</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
          <?php
            if(isset($_SESSION["user_enabled"]) && $_SESSION["user_enabled"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have successfully Enabled a User
            </div>  <?php
            unset($_SESSION["user_enabled"]);
            header('Refresh: 4; URL= view-all-users.php');
                      }
              ?>

          <?php
            if(isset($_SESSION["password_updated"]) && $_SESSION["password_updated"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have successfully Changed a Users Password
            </div>  <?php
            unset($_SESSION["password_updated"]);
            header('Refresh: 4; URL= view-all-users.php');
                      }
              ?>


          <?php
            if(isset($_SESSION["user_disabled"]) && $_SESSION["user_disabled"]==true)
                  { ?>
            <div class="alert alert-warning" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have successfully Disabled a User
            </div>  <?php
            unset($_SESSION["user_disabled"]);
            header('Refresh: 4; URL= view-all-users.php');
                      }
              ?>
              <div class="table-responsive">
        <?php
        if(isset($users) && count($users)>0){ 
          $modal = 0;
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Date Added</th>
                      <th>Role</th>
                      <th>Action</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php

          foreach($users as $user){ 
            $modal++;
          ?>
                    <tr>
                      <td><?php echo $user['username']; ?></td>
                      <td><?php echo $user['firstname']; ?></td>
                      <td><?php echo $user['lastname']; ?></td>
                      <td><?php $date = date_create($user['date_added']); echo date_format($date,"d, M Y"); ?></td>
                      <td><?php echo $user['role_name']; ?></td>
                      <td><button data-toggle="modal" data-target="#passwordModal<?php echo $modal; ?>" class="btn btn-primary">Change Password</button></td>
                      <td><?php if($user['status'] == 1){  ?><div class="custom-control custom-switch">
  <input type="checkbox" checked="" class="custom-control-input" id="customSwitch1">
  <label class="custom-control-label" for="customSwitch1"><a href="view-all-users.php?disable_id=<?php echo $user['username']; ?>">Disable</a><?php  }else{  ?><div class="custom-control custom-switch">
  <input type="checkbox" class="custom-control-input" id="customSwitch1">
  <label class="custom-control-label" for="customSwitch1"><a href="view-all-users.php?enable_id=<?php echo $user['username']; ?>">Enable</a></label></div><?php } ?></td>
                    </tr>

<!-- Modal -->
<div class="modal fade" id="passwordModal<?php echo $modal; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change <?php echo $user['firstname'].' '.$user['lastname']; ?>'s Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="view-all-users.php" method="POST">
      <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
      </div>

      <button class="btn btn-primary" type="submit" name="change_password">Change Password</button>

      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                        echo "No Users Available";
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