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

if (isset($_GET['id'])) {
$id = $_GET['id'];
$deleteStudent = new Students();
$deleteStudent = $deleteStudent->deleteStudent($id);

}

if (isset($_POST['send_message'])) {
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $student_no = $_POST['student_no'];

  $sendMessage = new Staff();
  $sendMessage = $sendMessage->sendMessage($subject, $message, $student_no);
}


$getClasses = new Settings();
$classes = $getClasses->getClasses();

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getClasses = new Settings();
$all_classes = $getClasses->getClasses();

if (isset($_POST['change_class'])) {
$class_id = $_POST['class_id'];
$student_no = $_POST['student_no'];

$updateStudentClass = new Students();
$updateStudentClass = $updateStudentClass->updateStudentClass($class_id, $student_no);

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

  <title>View Students | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">View Students</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">View Students</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
          <?php
          if(isset($_SESSION["class_updated"]) && $_SESSION["class_updated"]==true)
                { ?>
          <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success! </strong>Student Class Changed Successfully
          </div>  <?php
          unset($_SESSION["class_updated"]);
          header('Refresh: 4; URL= view-students.php');
                    }
            ?>

          <?php
            if(isset($_SESSION["student-deleted"]) && $_SESSION["student-deleted"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Student Deleted Successfully
            </div>  <?php
            unset($_SESSION["student-deleted"]);
            header('Refresh: 4; URL= view-students.php');
                      }
              ?>

            <?php
            if(isset($_SESSION["message_sent"]) && $_SESSION["message_sent"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Message sent Successfully to Student
            </div>  <?php
            unset($_SESSION["message_sent"]);
            header('Refresh: 4; URL= messages.php');
                      }
              ?>
              <div class="table-responsive">
        <?php
        if(isset($students) && count($students)>0){ 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Date of Birth</th>
                      <th>Gender</th>
                      <th>Class Name</th>
                      <th>Email</th>
                      <th>Change Class</th>
                      <th>Action</th>
                      <th>Message</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          $i = 0;
          $modal = 0;
          foreach($students as $student){
          $i++;
          $modal++; 
          ?>
                    <tr>
                      <td><?php echo $student['name']; ?></td>
                      <td><?php $date = date_create($student['dob']); echo date_format($date,"d, M Y"); ?></td>
                      <td><?php echo $student['gender']; ?></td>
                      <td><?php echo $student['class_name']; ?></td>
                      <td><?php echo $student['email']; ?></td>
                      <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#change<?php echo $modal; ?>class">
                        <i style="font-size: 25px;" class="fab fa-buffer"></i>
                      </button></td>
                      <td>

    <!-- Button for Message modal -->
<button type="button" title="Send Message" class="btn btn-primary" data-toggle="modal" data-target="#contact<?php echo $i; ?>modal">
<i style="font-size: 25px;" class="far fa-envelope-open"></i>
</button>

</div>
</td>
<td><i class="fas fa-trash text-gray-800"></i> <a href="#">Delete</a></td>

<!-- Change class Modal -->
<div class="modal fade" id="change<?php echo $modal; ?>class" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change <?php echo $student['name']; ?>'s Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p style="color: blue;">Choose new Class Below:</p>

        <form action="view-students.php" method="POST">
        <input type="hidden" name="student_no" value="<?php echo $student['student_no']; ?>">
        <select name="class_id" class="custom-select">
            <?php
            if(isset($all_classes) && count($all_classes)>0){
              foreach($all_classes as $classes){ ?>
                  <option value="<?php echo $classes['id']; ?>"><?php echo $classes['name']; ?></option>
                  <?php 
                }
              }
            ?>

        </select>
        <br><br>
        <button type="submit" name="change_class" class="btn btn-primary"><i class="fas fa-edit"></i> Change Class</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="contact<?php echo $i; ?>modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Message <?php echo $student['name']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="view-students.php" method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">Subject</label>
            <input type="text" name="subject" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Subject/Heading" required="">
          </div>

        <div class="form-group">
          <label for="exampleFormControlTextarea1">Message</label>
          <textarea placeholder="Enter Message" required="" name="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <input type="text" hidden="" name="student_no" value="<?php echo $student['student_no']; ?>">
        <button type="submit" name="send_message" class="btn btn-primary"><i class="fas fa-envelope"></i> Send Message</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
                    </tr>
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
<?php include 'footer.php';  ?>