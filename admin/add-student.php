<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
  
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['add_student'])) {

     if(isset($_FILES['student_picture'])){
      $errors= array();
      $file_name = $_FILES['student_picture']['name'];
      $file_size =$_FILES['student_picture']['size'];
      $file_tmp =$_FILES['student_picture']['tmp_name'];
      $file_type=$_FILES['student_picture']['type'];
    $dot = ".";


    $imagePath = "../images/students/";
    $imagePath = $imagePath . basename($file_name);
     $file_ext = pathinfo($imagePath,PATHINFO_EXTENSION);
      $expensions= array("JPG", "jpg","PNG","png","GIF","gif");

      if(in_array($file_ext,$expensions)=== false){
         $errors[]="This file extension is not allowed.";
      }

      if($file_size > 3007152){

         $errors[]='File size must be not more than 3 MB';

      }

      if(empty($errors)==true){
    move_uploaded_file($file_tmp, $imagePath);

      }else{
       $errors[]='Error Uploading file';
      }
     
    $image_Path = $imagePath;
   }

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $nationality = $_POST['nationality'];
    $student_no = $_POST['student_no'];
    $password = $_POST['password'];
    $dob = $_POST['dob']; 
    $gender = $_POST['gender'];

   $addStudent = new Students();
   $addStudent->addStudent($image_Path, $firstname, $lastname, $email, $nationality, $student_no, $password, $dob, $gender);
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

  <title>Add Student | MRC</title>

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
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add Student</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Add student</h1>
        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-1"></div>
  <div class="col-md-10 col-xs-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
            <?php
            if(isset($_SESSION["student_found"]) && $_SESSION["student_found"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Student Already Exist! </strong> Student is present in the system
            </div>  <?php
            unset($_SESSION["student_found"]);
                      }
              ?>
            <?php
            if(isset($_SESSION["student-added"]) && $_SESSION["student-added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Student Added Successfully
            </div>  <?php
            unset($_SESSION["student-added"]);
            header('Refresh: 5; URL= view-students.php');
                      }
              ?>
          <form action="add-student.php" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col">
                <label for="inputEmail4">First Name</label>
                <input type="text" name="firstname" class="form-control" placeholder="Enter First name" required="">
                </div>
                <div class="col">
                <label for="inputEmail4">Last Name</label>
                <input type="text" name="lastname" class="form-control" placeholder="Enter Last name" required="">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col">
                  <label for="inputEmail4">Email</label>
                  <input type="email" name="email" class="form-control" placeholder="Enter Email" required="">
                </div>
                <div class="col">
                  <label for="inputEmail4">Nationality</label>
                  <input type="text" name="nationality" class="form-control" placeholder="Enter Nationality" required="">
                </div>
              </div>
              <br>
              <div class="custom-file">
                <input type="file" name="student_picture" class="custom-file-input" id="customFile" required="">
                <label class="custom-file-label" for="customFile">Choose Student Picture</label>
              </div>
              <br>
              <br>
              <div class="form-group">
                <label for="exampleInputEmail1">Student No:</label>
                <input type="text" name="student_no" class="form-control"  placeholder="Enter Student Number" required="">
                <small style="color: red;">This will be used as username</small>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
              </div>
              <div class="row">
                <div class="col">
                  <label for="inputEmail4">Date of Birth</label>
                  <input type="date" name="dob" class="form-control" placeholder="Select Date of Birth" required="">
                </div>
                <div class="col">
                  <label for="inputEmail4">Select Gender</label>
                  <select name="gender" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                    <option selected>Gender...</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
              <br>
              <button type="submit" name="add_student" class="btn btn-primary">Add Student <i class="fas fa-plus"></i></button>
            </form>
      </div>
    </div>
    <!--End of Adding Student Card -->

  </div>
  <div class="col-md-1"></div>
</div>

      </div>
      <!-- End of Main Content -->
<?php include 'footer.php';  ?>