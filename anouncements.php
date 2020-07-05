<?php
include_once 'functions/functions.php';
$page = 3; //Announcements

$getAnnouncements = new Staff();
$announcements = $getAnnouncements->getAnnouncements();
?>
<?php include_once"header.php"; ?>

  <main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Announcements <i class="fas fa-bullhorn"></i></h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Announcements</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Services Section ======= -->
    <section style="padding-top: 18px;" id="services" class="services">
      <div class="container">
        <div class="section-title">
          <h2>new announcements <button class="btn btn-outline-success"><a href=""><i class="fas fa-download"></i> Download PDF</button></a></h2>
        </div>

        <div class="row">
        <?php
        $i = 0;
        if(isset($announcements) && count($announcements)>0){ 
            foreach($announcements as $announcement){ 
          $i ++;
          ?>
          <div class="col-md-6 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="icofont-megaphone-alt"></i>
              <h4><a href="" data-toggle="modal" data-target="#edit<?php echo $i; ?>modal"><?php echo substr($announcement['title'],0, 70);?></a></h4>
              <p><?php echo substr($announcement['description'],0, 160);?>.... <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#edit<?php echo $i; ?>modal">Read More</button></p>
              <i style="font-size: 20px; padding-right: 5px;" class="fas fa-calendar-week"></i> <?php $date = date_create($announcement['date_added']); echo date_format($date,"d, M Y"); ?>
            </div>
          </div>

                             <!-- Modal -->
          <div class="modal fade" id="edit<?php echo $i; ?>modal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModal">Read More <i class="fas fa-book-reader"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="card shadow">
                      <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $announcement['title']; ?></h6>
                      </div>
                      <div class="card-body">
                        <?php echo $announcement['description']; ?>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
         <?php  } ?>

                <?php
                      }else { ?>
                          <div align="center" class="col-md-12 col-xs-12">
                          <p>No Announcements Available, Check back later <i style="font-size: 20px;" class="far fa-frown"></i></p>
                          <i style="font-size: 100px;" class="fas fa-bullhorn"></i>
                          </div> 
                   <?php   }
        ?>
        </div>

      </div>
    </section><!-- End Services Section -->
<style>
.btn-group-xs > .btn, .btn-xs {
  padding: .30rem .4rem;
  font-size: .875rem;
  line-height: .5;
  border-radius: .3rem;
}
</style>
  </main><!-- End #main -->

<?php include_once 'footer.php'; ?>