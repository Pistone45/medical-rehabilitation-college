<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getSpecificTeacher = new Teacher();
$teacher = $getSpecificTeacher-> getSpecificTeacher();

if (isset($_POST['edit'])) {

  $statusMsg = '';
  //file upload path
  $targetDir = "../images/teachers/";
  $fileName = basename($_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

  if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
      //allow certain file formats
      $allowTypes = array('docx','pdf');
      if(in_array($fileType, $allowTypes)){
          //upload file to server
          if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
              //$statusMsg = "The file ".$fileName. " has been uploaded.";

              if(strlen($targetFilePath)==19){
                $targetFilePath = $_POST['url'];
              }

              $picture = $targetFilePath;
              $firstname = $_POST['firstname'];
              $middlename = $_POST['middlename'];
              $lastname = $_POST['lastname'];
              $dob = $_POST['dob'];
              $phone = $_POST['phone'];

              $editTeacher = new Teacher();
              $editTeacher = $editTeacher->editTeacher($firstname, $middlename, $lastname, $dob, $phone, $picture);


            $addMaterial = new Teacher();
            $addMaterial = $addMaterial->addMaterial($title, $material, $modules_id, $classes_id, $year, $semester_id);

          }else{
              $_SESSION['error']=true;
          }
      }else{
          $_SESSION['type_mismatch']=true;
      }
  }else{
      //$statusMsg = 'Please select a file to upload.';
  }

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

  <title>Your Profile | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Your Profile</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Your Profile</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-6">

  <!-- Basic Card Example -->
    <div class="card shadow">
      <div class="card-body">
      <?php
      if(isset($_SESSION["teacher_edited"]) && $_SESSION["teacher_edited"]==true)
            { ?>
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success! </strong> Profile Edited Successfully
      </div>  <?php
      unset($_SESSION["teacher_edited"]);
      header('Refresh: 5; URL= view-profile.php');
                }
        ?>
                    <?php
            if(isset($_SESSION["type_mismatch"]) && $_SESSION["type_mismatch"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Wrog file Type! </strong> Only PDF and Word Documents are allowed
            </div>  <?php
            unset($_SESSION["type_mismatch"]);
                      }
              ?>
      <form action="view-profile.php" method="POST" enctype="multipart/form-data">
        <div class="custom-control custom-switch">
          <input type="checkbox" class="custom-control-input agree" id="customSwitch1">
          <label class="custom-control-label" for="customSwitch1">Enable Editing</label>
        </div>
        <hr>
        <div class="form-group">
          <label for="inputAddress">ID/Username</label>
          <input type="text" disabled="" class="form-control" value="<?php if(isset($teacher)){echo $teacher['teacher_id'];} ?>">
        </div>
        <div class="form-group">
          <label for="inputAddress">First Name</label>
          <input type="text" name="firstname" class="form-control" id="text" value="<?php if(isset($teacher)){echo $teacher['firstname'];} ?>">
        </div>
        <div class="form-group">
          <label for="inputAddress">Middle Name</label>
          <input type="text" name="middlename" class="form-control" id="text" value="<?php if(isset($teacher)){echo $teacher['middlename'];} ?>">
        </div>
        <div class="form-group">
          <label for="inputAddress">Last Name</label>
          <input type="text" name="lastname" class="form-control" id="text" value="<?php if(isset($teacher)){echo $teacher['lastname'];} ?>">
        </div>
        <div class="form-group">
          <label for="inputAddress">Date of Birth</label>
          <input type="date" name="dob" class="form-control" id="text" value="<?php if(isset($teacher)){echo $teacher['dob'];} ?>">
        </div>
      
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-6">
      <!-- Basic Card Example -->
    <div class="card shadow">
      <div class="card-body">
        <div class="form-group">
          <label for="inputAddress">Phone</label>
          <input type="phone" name="phone" class="form-control" id="text" value="<?php if(isset($teacher)){echo $teacher['phone'];} ?>">
        </div>
        <div class="form-group">
          <label for="inputAddress">Email</label>
          <input type="email" name="email" class="form-control" id="text" value="<?php if(isset($teacher)){echo $teacher['email'];} ?>">
        </div>
        <div class="form-group">
          <label for="inputAddress">Nationality</label>
          <input type="text" name="nationality" class="form-control" id="" value="<?php if(isset($teacher)){echo $teacher['nationality'];} ?>"disabled>
        </div>
        <div class="form-group">
          <label for="inputAddress">Image</label>
          <br>
          <input type="hidden" value="<?php if(isset($teacher)){echo $teacher['picture'];} ?>" name="url" />
          <img width="160" height="110" src="<?php if(isset($teacher)){echo $teacher['picture'];} ?>" id="text">
        </div>
        <div class="custom-file">
          <input type="file" name="file" class="custom-file-input" id="text">
          <label class="custom-file-label" for="customFile">Choose New Picture</label>
        </div>
        <br><br>
      <div>
      <button id="text" type="submit" name="edit" class="btn btn-outline-success">Edit Profile <i style="font-size: 18px;" class="fas fa-arrow-circle-right"></i></button>
      </div>
  </form>
  </div>
</div>

</div>
<!-- End of Main Content -->
<style type="text/css">
  label{color: black;}
</style>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    $(document).ready(function(){
    $('div input[id="text"]').prop("disabled", true);
    $(".agree").click(function(){
            if($(this).prop("checked") == true){
                $('div input[id="text"]').prop("disabled", false);
            }
            else if($(this).prop("checked") == false){
                $('div input[id="text"]').prop("disabled", true);
            }
        });
    });
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

<?php include 'footer.php';  ?>