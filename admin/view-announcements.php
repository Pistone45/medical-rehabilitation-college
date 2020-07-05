<?php
include_once '../functions/functions.php';
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit;
}
  
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

$getAnnouncements = new Staff();
$announcements = $getAnnouncements->getAnnouncements();

if (isset($_POST['add'])) {
 $title = $_POST['title'];
 $description = $_POST['description'];

 $addAnnouncement = new Staff();
 $addAnnouncement = $addAnnouncement->addAnnouncement($title, $description);
}


if (isset($_POST['edit'])) {
 $id = $_POST['id'];
 $title = $_POST['title'];
 $description = $_POST['description'];

 $editAnnouncement = new Staff();
 $editAnnouncement = $editAnnouncement->editAnnouncement($id, $title, $description);
}

if (isset($_POST['delete'])) {
$id = $_POST['id'];
$deleteAnnouncement = new Staff();
$deleteAnnouncement = $deleteAnnouncement->deleteAnnouncement($id);

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

  <title>Announcements | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">Announcements</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">View/Add Announcements</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modal">
     <i class="fas fa-plus"></i> Add Announcement
    </button>

      <div class="card-body">
            <?php
            if(isset($_SESSION["announcement_added"]) && $_SESSION["announcement_added"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Announcement Added Successfully
            </div>  <?php
            unset($_SESSION["announcement_added"]);
            header('Refresh: 4; URL= view-announcements.php');
                      }
              ?>
            <?php
            if(isset($_SESSION["announcement_edited"]) && $_SESSION["announcement_edited"]==true)
                  { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Announcement Edited Successfully
            </div>  <?php
            unset($_SESSION["announcement_edited"]);
            header('Refresh: 4; URL= view-announcements.php');
                      }
              ?>
            <?php
            if(isset($_SESSION["announcement_deleted"]) && $_SESSION["announcement_deleted"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> Announcement Deleted Successfully
            </div>  <?php
            unset($_SESSION["announcement_deleted"]);
            header('Refresh: 4; URL= view-announcements.php');
                      }
              ?>
              <div class="table-responsive">
        <?php
        $i = 0;
        if(isset($announcements) && count($announcements)>0){ 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Date Added</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($announcements as $announcement){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo substr($announcement['title'],0, 70); ?></td>
                      <td><?php echo substr($announcement['description'],0, 150); ?>.......</td>
                      <td><?php $date = date_create($announcement['date_added']); echo date_format($date,"d, M Y"); ?></td>
                      <td><a href="" data-toggle="modal" data-target="#edit<?php echo $i; ?>modal" class="btn btn-success btn-circle"><i class="fas fa-edit"></i></a>
                      </td>
                      <td>
                      <form action="view-announcements.php" method="POST">
                      <input type="text" hidden="" name="id" value="<?php echo $announcement['id']; ?>">
                      <button name="delete" type="submit" class="btn btn-danger"><i class="fas fa-trash"></button></i>
                      </form>
                      </td>
                    </tr>

          <!-- Modal -->
          <div class="modal fade" id="edit<?php echo $i; ?>modal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Edit Announcement <i class="fas fa-edit"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <form action="view-announcements.php" method="POST">
                    <input type="text" hidden="" name="id" value="<?php echo $announcement['id']; ?>">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Title</label>
                      <input type="text" name="title" class="form-control" value="<?php echo $announcement['title']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Description</label>
                      <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $announcement['description']; ?></textarea>
                    </div>

                    <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Announcement</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Announcement <i class="fas fa-bullhorn"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="view-announcements.php" method="POST">

        <div class="form-group">
          <label for="exampleInputEmail1">Title</label>
          <input type="text" name="title" class="form-control" placeholder="Enter Announcement Title" required="">
          <small id="emailHelp" class="form-text text-muted">Title will appear exactly as above</small>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Description</label>
          <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3" required="" placeholder="Enter Announcement Description here"></textarea>
        </div>

        <button type="submit" name="add" class="btn btn-primary"><i class="fas fa-plus"></i> Add Announcement</button>
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
<?php include 'footer.php';  ?>