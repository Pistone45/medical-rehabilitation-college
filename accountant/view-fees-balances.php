<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['id'])) {
  $student_no = $_GET['id'];

  $resolveFeesBalance = new Accountant();
  $resolveFeesBalance = $resolveFeesBalance->resolveFeesBalance($student_no);

}

if (isset($_POST['add_installment'])) {
  $amount = $_POST['amount'];
  $fees_id = $_POST['fees_id'];

  $addBalanceInstallment = new Accountant();
  $addBalanceInstallment->addBalanceInstallment($amount, $fees_id);

}


$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getStudentsBalances = new Accountant();
$balances = $getStudentsBalances->getStudentsBalances();


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Fees Balances | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Fees Balances</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">All Fees Balances</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
            <?php
            if(isset($_SESSION["fees_resolved"]) && $_SESSION["fees_resolved"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have Successfully Resolved fees Balance for a Student
            </div>  <?php
            unset($_SESSION["fees_resolved"]);
            header('Refresh: 4; URL= view-fees-balances.php');
                      }
              ?>

             <?php
            if(isset($_SESSION["imstallment_added"]) && $_SESSION["imstallment_added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have Successfully Added an Installment to a Balance
            </div>  <?php
            unset($_SESSION["imstallment_added"]);
            header('Refresh: 4; URL= view-fees-balances.php');
                      }
              ?>             
              <div class="table-responsive">
        <?php
        if(isset($balances) && count($balances)>0){
        $i = 0; 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Balance</th>
                      <th>Date Recorded</th>
                      <th>Action</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($balances as $balance){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $balance['students_student_no']; ?></td>
                      <td><?php echo $balance['name']; ?></td>
                      <td><?php echo $balance['class']; ?></td>
                      <td>K<?php echo number_format($balance['balance']); ?></td>
                      <td><?php $date = date_create($balance['date_recorded']); echo date_format($date,"d, M Y"); ?></td>
                      <td><button data-toggle="modal" data-target="#installModal<?php echo $i; ?>" class="btn btn-primary">Add Installment</button></td>
                      <td><a href="view-fees-balances.php?id=<?php echo $balance['students_student_no']; ?>"><i class="fas fa-check-circle fa-1x"></i> Resolve Fees</a></td>
                    </tr>

<!-- Installment Modal -->
<div class="modal fade" id="installModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Installment to <?php echo $balance['name']; ?>'s Balance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form action="view-fees-balances.php" method="POST">
      <input type="hidden" name="fees_id" value="<?php echo $balance['id']; ?>">
      <div class="form-group">
        <label for="exampleInputEmail1">Amount</label>
        <input type="number" name="amount" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Installment Amount">
        <small style="color: red;" id="emailHelp" class="form-text text-muted">System will deduct this amount from the current Balance</small>
      </div>
        <button type="submit" name="add_installment" class="btn btn-primary">Add Installment <i class="fas fa-plus"></i></button>
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
                        echo "No Students with Fees Balances Available";
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
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
    
  <script type="text/javascript">
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
  </script>
<?php include 'footer.php';  ?>