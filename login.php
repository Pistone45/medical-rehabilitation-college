<?php  
include_once ('functions/functions.php');

if (isset($_POST['login'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	
	$login = new User();
	$login->login($username, $password);
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

  <title>MRC | Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div style="padding-top: 5px;" class="container">
    <a href="index.php"><button class="btn btn-outline-success btn-lg"><i class="fas fa-undo"></i> Back to Site</button></a>
    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div style="padding-top: 0px;" class="col-xl-6 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div style="padding-top: 0px;" class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img style="padding-bottom: 10px;" width="135" height="135" src="images/logo.jpg">
                  </div>
                  <form action="login.php" method="POST">
                    <div class="form-group">
                      <input type="text" name="username" class="form-control" id="Username" placeholder="Enter Username..." required="">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control" id="" placeholder="Password" required="">
                    </div>
                   <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                  </form>
                  <br>
            <?php
            if(isset($_SESSION["invalidUser"]) && $_SESSION["invalidUser"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Failed!</strong> Wrong Credentials, try again
            </div>  <?php
            unset($_SESSION["invalidUser"]);
                      }
              ?>

            <?php
            if(isset($_SESSION["invalidRole"]) && $_SESSION["invalidRole"]==true)
                  { ?>
            <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Wrong Role!</strong> You are not Assigned a role. Contact the Admin
            </div>  <?php
            unset($_SESSION["invalidRole"]);
                      }
              ?>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="#">Forgot Password?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
<script type="text/javascript">
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
  </script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
