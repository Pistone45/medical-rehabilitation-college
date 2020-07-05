<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
  
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getTeamMember = new Staff();
$members = $getTeamMember->getTeamMember();

if (isset($_POST['add'])) {

     if(isset($_FILES['file'])){
      $errors= array();
      $file_name = $_FILES['file']['name'];
      $file_size =$_FILES['file']['size'];
      $file_tmp =$_FILES['file']['tmp_name'];
      $file_type=$_FILES['file']['type'];
    $dot = ".";


    $imagePath = "../images/team/";
    $imagePath = $imagePath . basename($file_name);
     $file_ext = pathinfo($imagePath,PATHINFO_EXTENSION);
      $expensions= array("JPG", "jpg","PNG","png","GIF","gif");

      if(in_array($file_ext,$expensions)=== false){
         $_SESSION['type_mismatch'] = true;
      }

      if($file_size > 3007152){
        $_SESSION['big_file'] = true;

      }

      if(empty($errors)==true){
    move_uploaded_file($file_tmp, $imagePath);

        $picture = $imagePath;
        $name = $_POST['name'];
        $position = $_POST['position'];
        $description = $_POST['description'];

        $addTeamMember = new Staff();
        $addTeamMember = $addTeamMember->addTeamMember($name, $position, $description, $picture);

      }else{
       $_SESSION['error'] = true;
      }
     
    $image_Path = $imagePath;
   }

}

if (isset($_POST['edit'])) {
 $id = $_POST['id'];
 $name = $_POST['name'];
 $position = $_POST['position'];
 $description = $_POST['description'];

 $editTeamMember = new Staff();
 $editTeamMember = $editTeamMember->editTeamMember($id, $name, $position, $description);
}

if (isset($_POST['delete'])) {
$id = $_POST['id'];
$picture = $_POST['picture'];
$deleteMember = new Staff();
$deleteMember = $deleteMember->deleteMember($id, $picture);

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

  <title>The team | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">The team</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">View/Add Team member</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal">
     <i class="fas fa-plus"></i> Add Team Member/Employee <i class="fas fa-users"></i>
    </button>

      <div class="card-body">
            <?php
            if(isset($_SESSION["member_added"]) && $_SESSION["member_added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Team Member Added Successfully
            </div>  <?php
            unset($_SESSION["member_added"]);
            header('Refresh: 4; URL= the-team.php');
                      }
              ?>
            <?php
            if(isset($_SESSION["member_edited"]) && $_SESSION["member_edited"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Member Edited Successfully
            </div>  <?php
            unset($_SESSION["member_edited"]);
            header('Refresh: 4; URL= the-team.php');
                      }
              ?>
            <?php
            if(isset($_SESSION["member_deleted"]) && $_SESSION["member_deleted"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Member Deleted Successfully
            </div>  <?php
            unset($_SESSION["member_deleted"]);
            header('Refresh: 4; URL= the-team.php');
                      }
              ?>
                          <?php
            if(isset($_SESSION["type_mismatch"]) && $_SESSION["type_mismatch"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Wrog file Type! </strong> Only Pictures are allowed
            </div>  <?php
            unset($_SESSION["type_mismatch"]);
                      }
              ?>
            <?php
            if(isset($_SESSION["error"]) && $_SESSION["error"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error! </strong> There was an error uploading the Image. Contact the Admin
            </div>  <?php
            unset($_SESSION["error"]);
                      }
              ?>
              <?php
            if(isset($_SESSION["big_file"]) && $_SESSION["big_file"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Error! </strong> File size must be not more than 3 MB
            </div>  <?php
            unset($_SESSION["big_file"]);
                      }
              ?>
              <div class="table-responsive">
        <?php
        $i = 0;
        if(isset($members) && count($members)>0){ 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Description</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($members as $member){ 
          $i ++;
          ?>
                    <tr>
                      <td><img height="90" width="120" src="<?php echo $member['picture']; ?>"></td>
                      <td><?php echo $member['name']; ?></td>
                      <td><?php echo $member['position']; ?></td>
                      <td><?php echo substr($member['description'],0, 100); ?>....</td>
                      <td><a href="" data-toggle="modal" data-target="#edit<?php echo $i; ?>modal" class="btn btn-success btn-circle"><i class="fas fa-edit"></i></a>
                      </td>
                      <td>
                      <form action="the-team.php" method="POST">
                      <input type="text" hidden="" name="id" value="<?php echo $member['id']; ?>">
                      <input type="text" hidden="" name="picture" value="<?php echo $member['picture']; ?>">
                      <button name="delete" type="submit" class="btn btn-danger"><i class="fas fa-trash"></button></i>
                      </form>
                      </td>
                    </tr>

          <!-- Modal -->
          <div class="modal fade" id="edit<?php echo $i; ?>modal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Edit Team Member <i class="fas fa-edit"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <form action="the-team.php" method="POST">
                    <input type="text" hidden="" name="id" value="<?php echo $member['id']; ?>">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Full Name</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $member['name']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Position</label>
                      <input type="text" name="position" class="form-control" value="<?php echo $member['position']; ?>" required="">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Description</label>
                      <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $member['description']; ?></textarea>
                    </div>

                    <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Member</button>
                  </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            
         <?php  } ?>

                  </tbody>
                </table>
                <?php
                      }else { ?>
                          <div align="center">
                          <p>No Announcements Available, Add some <i class="fas fa-arrow-alt-circle-up"></i></p>
                          <i style="font-size: 100px;" class="fas fa-bullhorn"></i>
                          </div> 
                   <?php   }
        ?>
              </div>
      </div>
    </div>
    <!--End of Basic Card Example -->
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Team Member <i class="fas fa-users"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="the-team.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
          <label for="exampleInputEmail1">Name</label>
          <input type="text" name="name" class="form-control" placeholder="Enter Full Name" required="">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Position</label>
          <input type="text" name="position" class="form-control" placeholder="Enter Position at the college" required="">
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Description</label>
          <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3" required="" placeholder="Enter Employee Description here"></textarea>
        </div>
        <div class="custom-file">
          <input type="file" name="file" class="custom-file-input" required>
          <label class="custom-file-label" for="validatedCustomFile">Choose Picture...</label>
          <div class="invalid-feedback">Please Select Picture</div>
        </div>
        <br><br>

        <button type="submit" name="add" class="btn btn-primary"><i class="fas fa-plus"></i> Add Member</button>
      </form>
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
<?php include 'footer.php';  ?>