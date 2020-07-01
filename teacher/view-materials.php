<?php
include_once '../functions/functions.php';
$getUserProfile = new User();
$user_details = $getUserProfile-> getUserProfile();

if (isset($_POST['filter'])) {
  $classes_id = $_POST['classes_id'];
  $modules_id = $_POST['modules_id'];

  $getMaterialsPerClassModule = new Teacher();
  $materials = $getMaterialsPerClassModule->getMaterialsPerClassModule($classes_id, $modules_id);

  $getModuleName = new Teacher();
  $module = $getModuleName->getModuleName($modules_id);

  $getClassName = new Teacher();
  $class = $getClassName->getClassName($classes_id);
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

  <title>View Materials | MRC</title>

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
    <li class="breadcrumb-item active" aria-current="page">View Materials</li>
  </ol>
</nav>
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?php echo $class['name']; ?>'s <?php echo $module['name']; ?> Materials</h1>
          

        </div>
        <!-- /.container-fluid -->

<div class="row container-fluid">
  <div class="col-md-12">

  <!-- Basic Card Example -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
        <?php
        if(isset($materials) && count($materials)>0){
        $i = 0; 
          ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Class</th>
                      <th>Module</th>
                      <th>Semester</th>
                      <th>Year</th>
                      <th>Date Added</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php
          foreach($materials as $material){ 
          $i ++;
          ?>
                    <tr>
                      <td><?php echo $material['title']; ?></td>
                      <td><?php echo $material['class_name']; ?></td>
                      <td><?php echo $material['module_name']; ?></td>
                      <td><?php if($material['semester_id']==1){echo "1st Semester";}elseif($material['semester_id']==2){echo "2nd Semester";} ?></td>
                      <td><?php echo $material['year']; ?></td>
                      <td><?php $date = date_create($material['date_added']); echo date_format($date,"d, M Y"); ?></td>
                      <td><a href=""><button class="btn btn-outline-primary"><i style="font-size: 18px;" class="fas fa-download"> Download</button></a></td>
                    </tr>

          <?php
            
          } ?>

                  </tbody>
                </table>
                <?php
                      }else {
                        echo "No Materials Available for this Class and Module"; 
                          ?> <a href="filter-materials.php"> <button class="btn btn-outline-primary">Back <i style="font-size: 18px;" class="fas fa-undo"></i></button></a> <?php
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