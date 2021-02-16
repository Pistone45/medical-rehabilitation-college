<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}

$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getAllClasses = new User();
$classes = $getAllClasses-> getAllClasses();

$getSemesters = new Settings();
$semesters = $getSemesters->getSemesters();

$getCurrentSettings = new Settings();
$settings = $getCurrentSettings->getCurrentSettings();

$year =(int)$settings['year'];
//from academic_year get the last 10 years
$ten_years = $year-10;
$years =range($year,$ten_years,-1);

if (isset($_POST['submit'])) {
  $statusMsg = '';
  //file upload path
  $targetDir = "../materials/";
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

            $year = $_POST['year'];
            $semester_id = $_POST['semester_id'];
            $material = $targetFilePath;
            $classes_id = $_POST['class_id'];
            $modules_id = $_POST['modules_id'];
            $title = $_POST['title'];

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

  <title>Add Materials | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Add Materials</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Add Materials</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-7">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
      <?php
            if(isset($_SESSION["material_added"]) && $_SESSION["material_added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> You have Successfully Added a Learning Material for This Class and Module
            </div>  <?php
            unset($_SESSION["material_added"]);
            header('Refresh: 5; URL= filter-materials.php');
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
            <?php
            if(isset($_SESSION["error"]) && $_SESSION["error"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error! </strong> There was an error uploading the file. Contact the Admin
            </div>  <?php
            unset($_SESSION["error"]);
                      }
              ?>
            <?php
            if(isset($_SESSION["material_present"]) && $_SESSION["material_present"]==true)
                  { ?>
            <div class="alert alert-warning" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Material Present </strong> The Material for this Class and Subject is already Present
            </div>  <?php
            unset($_SESSION["material_present"]);
                      }
              ?>
        <form action="add-materials.php" method="POST" enctype="multipart/form-data">
        <label>Select Class</label>
          <select class="custom-select" name="class_id" onchange="showModule(this.value)" id="class_id" required="">
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

        <label>Select Subject</label>
        <select class="custom-select" name="modules_id" id="module_name" required="">
          <option VALUE="">Select Module</option>  
        </select>
        <br><br>

        <div class="form-group">
          <label for="inputAddress">Title</label>
          <input type="text" name="title" class="form-control" id="inputAddress" placeholder="Enter Material Title" required="">
        </div>

        <label>Material</label>
        <div class="custom-file">
          <input type="file" name="file" class="custom-file-input" required>
          <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
          <div class="invalid-feedback">Please Select Material</div>
        </div>
        <br><br>
      <label>Select Year</label>
        <select required="" name="year" class="form-control">
           <?php
            if(isset($years) && count($years)>0){
              foreach($years as $year){ ?>
                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
              <?php
                
              }
            }
          ?>
        </select>
      <br>
      <label>Select Semester</label>
        <select required="" name="semester_id" class="form-control">
           <?php
            if(isset($semesters) && count($semesters)>0){
              foreach($semesters as $semester){ ?>
                <option value="<?php echo $semester['id']; ?>"><?php echo $semester['name']; ?></option>
              <?php
                
              }
            }
          ?>
        </select>
      <br>

        <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-plus"></i> Add Material <i class="fas fa-paperclip"></i></button>
        </form>
      </div>
    </div>
    <!--End of Basic Card Example -->

  </div>
  <div class="col-md-5">
    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 28rem;" src="../images/undraw_attached_file_n4wm.svg" alt="">
  </div>
</div>

</div>
<!-- End of Main Content -->
<style type="text/css">
  label{color: black;}
</style>
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
<?php include 'footer.php';  ?>