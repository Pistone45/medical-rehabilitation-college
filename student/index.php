<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$checkPassword = new User();
$checkPassword-> checkPassword();

$countAllUnreadNotifications = new Students();
$count = $countAllUnreadNotifications-> countAllUnreadNotifications();

$countAllUnreadMessages = new Students();
$count_unread = $countAllUnreadMessages-> countAllUnreadMessages();

$getFeesBalancePerStudent = new Students();
$feesBalance = $getFeesBalancePerStudent-> getFeesBalancePerStudent();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Student Dashboard | MRC</title>

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

        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Student Dashboard</h1>
                    <!-- Content Row -->
          <div class="row">

            <!-- Fees Balance -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <a href="student-fees-balances.php">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Fees Balance</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php if($feesBalance['student_no'] == 0){ echo "No Balance";}else{echo "K".number_format($feesBalance['balance']);} ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
                </a>
              </div>
            </div>

            <!-- Unread Notifications -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <a href="notifications.php">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unread Notifications</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count['noti'];?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-bell fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
                </a>
              </div>
            </div>

            <!-- Unread Messages -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <a href="messages.php">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unread Messages</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $count_unread['message'] ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
                </a>
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php include 'footer.php';  ?>