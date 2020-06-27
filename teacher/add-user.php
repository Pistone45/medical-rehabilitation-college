<?php
include_once '../functions/functions.php';
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


if (isset($_POST['add_teacher'])) {

     if(isset($_FILES['teacher_picture'])){
      $errors= array();
      $file_name = $_FILES['teacher_picture']['name'];
      $file_size =$_FILES['teacher_picture']['size'];
      $file_tmp =$_FILES['teacher_picture']['tmp_name'];
      $file_type=$_FILES['teacher_picture']['type'];
    $dot = ".";


    $imagePath = "../images/teachers/";
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
    $teacher_id = $_POST['teacher_id'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];

   $addTeacher = new Staff();
   $addTeacher->addTeacher($image_Path, $firstname, $lastname, $email, $nationality, $teacher_id, $password, $dob, $gender, $qualification, $experience);
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

  <title>Dashboard</title>

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

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user_details['firstname'].' '.$user_details['lastname']; ?></span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../functions/logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>
        </nav>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb float-right">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add User</li>
  </ol>
</nav>

        <!-- End of Topbar -->   <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home">Student</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#menu1">Teacher</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane container active" id="home">
    <br>
    <!-- Add Student Card -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Student</h6>
      </div>
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
            header('Refresh: 5; URL= view-users.php');
                      }
              ?>
      <div class="card-body">
          <div class="row container-fluid">
            <div class="col-md-2"></div>
            <div class="col-md-8 col-xs-12">
              
            <form action="add-user.php" method="post" enctype="multipart/form-data">
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
            <div class="col-md-2"></div>
          </div>
      </div>
    </div>
    <!--End of Student Card -->
  
  </div>
  <div class="tab-pane container fade" id="menu1">
    <br>
    <!-- Add Teacher Card -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Teacher</h6>
      </div>
      <?php
            if(isset($_SESSION["teacher-found"]) && $_SESSION["teacher-found"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Teacher Already Exist! </strong> Teacher is present in the system
            </div>  <?php
            unset($_SESSION["teacher-found"]);
                      }
              ?>
            <?php
            if(isset($_SESSION["teacher-added"]) && $_SESSION["teacher-added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Teacher Added Successfully
            </div>  <?php
            unset($_SESSION["teacher-added"]);
            header('Refresh: 5; URL= view-users.php');
                      }
              ?>
      <div class="card-body">
                  <div class="row container-fluid">
            <div class="col-md-2"></div>
            <div class="col-md-8 col-xs-12">
              
            <form action="add-user.php" method="post" enctype="multipart/form-data">
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
                <input type="file" name="teacher_picture" class="custom-file-input" id="customFile" required="">
                <label class="custom-file-label" for="customFile">Choose Teacher Picture</label>
              </div>
              <br>
              <br>
              <div class="form-group">
                <label for="exampleInputEmail1">Teacher ID:</label>
                <input type="text" name="teacher_id" class="form-control"  placeholder="Enter Teacher ID" required="">
              </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
      <label for="validationTooltip03">Qualification</label>
      <input type="text" name="qualification" class="form-control" id="validationTooltip03" placeholder="E.g Degree" required>

    </div>
    <div class="col-md-4 mb-3">
      <label for="">Experience</label>
      <input type="text" name="experience" class="form-control" id="" placeholder="E.g 5" required>
    </div>
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
              <button type="submit" name="add_teacher" class="btn btn-primary">Add Teacher <i class="fas fa-plus"></i></button>
            </form>

            </div>
            <div class="col-md-2"></div>
          </div>
      </div>
    </div>
    <!--End of Teacher Card -->
    
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

     <?php include 'footer.php';  ?>