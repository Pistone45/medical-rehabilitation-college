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

if (isset($_POST['record'])) {
$balance = $_POST['balance'];
$student_no = $_POST['student_no'];
$remarks = $_POST['remarks'];

$RecordFeesBalance = new Accountant();
$RecordFeesBalance = $RecordFeesBalance->RecordFeesBalance($balance, $student_no, $remarks);

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

  <title>Record Fees Balance | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Record Balances</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Record Fees Balance</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
                    <?php
            if(isset($_SESSION["balance-recorded"]) && $_SESSION["balance-recorded"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have Successfully recorded fees Balance for a Student
            </div>  <?php
            unset($_SESSION["balance-recorded"]);
            header('Refresh: 5; URL= view-fees-balances.php');
                      }
              ?>
              <div class="table-responsive">
        <?php
        if(isset($students) && count($students)>0){
        $i = 0; 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Student ID</th>
                      <th>Name</th>
                      <th>Class</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($students as $student){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $student['student_no']; ?></td>
                      <td><?php echo $student['name']; ?></td>
                      <td><?php echo $student['gender']; ?></td>
                      <td>Class Name</td>
                      <td><!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#my<?php echo $i; ?>Modal">
  <i class="far fa-clipboard"></i> Record
</button></td>

                    </tr>
<!-- The Modal -->
  <div class="modal fade" id="my<?php echo $i; ?>Modal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Record Fees Balance for <?php echo $student['name']; ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        <form action="fees-balances.php" method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">Fees Balance</label>
            <input type="number" name="balance" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Balance" required="">
            <small id="emailHelp" class="form-text text-muted">No commas allowed.</small>
          </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Comment</label>
              <textarea name="remarks" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter comment"></textarea>
            </div>
          <input hidden="" type="text" name="student_no" value="<?php echo $student['student_no']; ?>">
          
          <button type="submit" name="record" class="btn btn-primary"><i class="far fa-clipboard"></i> Record</button>
        </form>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                        echo "No Students Available";
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
  <script type="text/javascript">
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
  </script>
<?php include 'footer.php';  ?>