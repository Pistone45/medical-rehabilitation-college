<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getModules = new Settings();
$modules = $getModules->getModules();

$getClasses = new Settings();
$classes = $getClasses->getClasses();

$getTimetableEntries = new Settings();
$timetables = $getTimetableEntries->getTimetableEntries();

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_GET['id'])) {
$id = $_GET['id'];
$deleteTimetableEntry = new Settings();
$deleteTimetableEntry = $deleteTimetableEntry->deleteTimetableEntry($id);

}

if (isset($_POST['add_entry'])) {
  $class_id = $_POST['class_id'];
  $modules_id = $_POST['modules_id'];
  $time_from = $_POST['time_from'];
  $time_to = $_POST['time_to'];
  $timetable_date = $_POST['timetable_date'];

  $addTimetableEntry = new Settings();
  $addTimetableEntry = $addTimetableEntry->addTimetableEntry($class_id, $modules_id, $time_from, $time_to, $timetable_date);

}

if (isset($_POST['edit_entry'])) {
  $entry_id = $_POST['entry_id'];
  $class_id = $_POST['class_id'];
  $modules_id = $_POST['modules_id'];
  $time_from = $_POST['time_from'];
  $time_to = $_POST['time_to'];
  $timetable_date = $_POST['timetable_date'];

  $editTimetableEntry = new Settings();
  $editTimetableEntry = $editTimetableEntry->editTimetableEntry($entry_id, $class_id, $modules_id, $time_from, $time_to, $timetable_date);

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

  <title>Timetable | MCA</title>

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
    <li class="breadcrumb-item active" aria-current="page">Timetable</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Timetable</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#exampleModal">
  Add Timetable Entry <i class="fas fa-plus"></i>
</button>

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
          <?php
            if(isset($_SESSION["entry_updated"]) && $_SESSION["entry_updated"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Timetable Entry updated Successfully
            </div><?php
            unset($_SESSION["entry_updated"]);
            header('Refresh: 4; URL= timetable.php');
                      }
              ?>

          <?php
            if(isset($_SESSION["entry_added"]) && $_SESSION["entry_added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Timetable Entry added Successfully
            </div><?php
            unset($_SESSION["entry_added"]);
            header('Refresh: 4; URL= timetable.php');
                      }
              ?>

          <?php
            if(isset($_SESSION["entry_deleted"]) && $_SESSION["entry_deleted"]==true)
                  { ?>
            <div class="alert alert-warning" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Timetable Entry Deleted Successfully
            </div><?php
            unset($_SESSION["entry_deleted"]);
            header('Refresh: 4; URL= timetable.php');
                      }
              ?>
              <div class="table-responsive">
        <?php
        $editModal = 0;
        $deleteModal = 0;
        if(isset($timetables) && count($timetables)>0){ 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Class</th>
                      <th>Module</th>
                      <th>Date</th>
                      <th>Time From</th>
                      <th>Time To</th>
                      <th>Action</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php

          foreach($timetables as $timetable){ 
            $editModal++;
            $deleteModal++;
          ?>
                    <tr>
                      <td><?php echo $timetable['class']; ?></td>
                      <td><?php echo $timetable['module']; ?></td>
                      <td><?php $date = date_create($timetable['timetable_date']); echo date_format($date,"d, M Y"); ?></td>
                      <td><?php $date = date_create($timetable['time_from']); echo date_format($date,"h:i A"); ?></td>
                      <td><?php $date = date_create($timetable['time_to']); echo date_format($date,"h:i A"); ?></td>
                      <td><i class="fas fa-edit text-gray-800"></i> <a data-toggle="modal" data-target="#editModal<?php echo $editModal; ?>" href="#">Edit</a></td>
                      <td data-toggle="modal" data-target="#deleteModal<?php echo $deleteModal; ?>"><i class="fas fa-trash text-gray-800"></i> Delete</td>
                    </tr>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal<?php echo $deleteModal; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <a href="view-timetable.php?id=<?php echo $timetable['id']; ?>"><button style="margin-right: 20px;" class="btn btn-danger">Yes</button></a> <button data-dismiss="modal" class="btn btn-success">No</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="editModal<?php echo $editModal; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo $timetable['class']; ?>'s Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <form action="timetable.php" method="POST">
        <input type="hidden" name="entry_id" value="<?php echo $timetable['id']; ?>">
        <label>Select Class</label>
          <select class="custom-select" name="class_id" onchange="showModule(this.value)" id="class_id" required="">
              <option value="<?php echo $timetable['classes_id']; ?>"><?php echo $timetable['class']; ?></option>
            <?php
              if(isset($classes) && count($classes)>0){
                foreach($classes as $class){ ?>
                  <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php
                  
                }
              }
            ?>
          </select>
        <br><br>

        <label>Select Subject/Module</label>
        <select class="custom-select" name="modules_id" id="module_name" required="">
          <option value="<?php echo $timetable['modules_id']; ?>"><?php echo $timetable['module']; ?></option>
        </select>
        <br><br>

          <div style="padding-top: 10px;" class="form-group">
            <label for="exampleInputEmail1">Date</label>
            <input type="date" name="timetable_date" class="form-control" value="<?php echo $timetable['timetable_date']; ?>">
          </div>

            <div style="padding-top: 15px;" class="row">
              <div class="col">
                <label for="inputEmail4">Time From:</label>
                <input type="time" name="time_from" class="form-control" value="<?php echo $timetable['time_from']; ?>">
                </div>
                <div class="col">
                <label for="inputEmail4">time To:</label>
                <input type="time" name="time_to" class="form-control" value="<?php echo $timetable['time_to']; ?>">
                </div>
              </div>
              <br>

      <button type="submit" name="edit_entry" class="btn btn-primary">Edit Entry <i class="fas fa-edit"></i></button>
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
                        echo "No Entries Available";
                      }
        ?>
              </div>
      </div>
    </div>
    <!--End of Basic Card Example -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Timetable Entry <i class="fas fa-plus"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-md-10">

      <form action="timetable.php" method="POST">
        <label>Select Class</label>
          <select class="custom-select" name="class_id" onchange="showModules(this.value)" id="classes_id" required="">
              <option style="color: black;" selected="">Select Class.....</option>
            <?php
              if(isset($classes) && count($classes)>0){
                foreach($classes as $class){ ?>
                  <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php
                  
                }
              }
            ?>
          </select>
        <br><br>

        <label>Select Subject/Module</label>
        <select class="custom-select" name="modules_id" id="modules_name" required="">
          <option VALUE="">Select Module</option>  
        </select>
        <br><br>

          <div style="padding-top: 10px;" class="form-group">
            <label for="exampleInputEmail1">Date</label>
            <input type="date" name="timetable_date" class="form-control" placeholder="Enter Date" required="">
          </div>

            <div style="padding-top: 10px;" class="row">
              <div class="col">
                <label for="inputEmail4">Time From:</label>
                <input type="time" name="time_from" class="form-control"  required="">
                </div>
                <div class="col">
                <label for="inputEmail4">time To:</label>
                <input type="time" name="time_to" class="form-control" required="">
                </div>
              </div>
              <br>

      <button type="submit" name="add_entry" class="btn btn-primary">Add Entry <i class="fas fa-plus"></i></button>
      </form>


          </div>
          <div class="col-md-1"></div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


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

<script type="text/javascript">
function showModule(val) {
  // alert(val);
  $.ajax({
  type: "POST",
  url: "filter-results.php",
  data:'class_id='+val,
  success: function(data){
    // alert(data);
    $("#module_name").html(data);
  }
  });
  
}
</script>


<script type="text/javascript">
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
  </script>

<script type="text/javascript">
function showModules(val) {
  // alert(val);
  $.ajax({
  type: "POST",
  url: "filter-more-results.php",
  data:'classes_id='+val,
  success: function(data){
    // alert(data);
    $("#modules_name").html(data);
  }
  });
  
}
</script>

<?php include 'footer.php';  ?>