      <?php 
          $getUnreadNotificationPerStudent = new Students();
          $not = $getUnreadNotificationPerStudent->getUnreadNotificationPerStudent();

          $countAllUnreadNotifications = new Students();
          $notification = $countAllUnreadNotifications-> countAllUnreadNotifications();

          $getUnreadMessagesPerStudent = new Students();
          $unread = $getUnreadMessagesPerStudent->getUnreadMessagesPerStudent();

          $countAllUnreadMessages = new Students();
          $count_unread = $countAllUnreadMessages-> countAllUnreadMessages();
      ?>
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

            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge <?php if($notification['noti'] == 0){  ?>badge-primary<?php  }else{ ?>badge-danger<?php  } ?> badge-counter"><?php echo $notification['noti']; ?></span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notifications
                </h6>
                <?php
                if(isset($not) && count($not)>0){
                    foreach($not as $nots){ ?>
                <a class="dropdown-item d-flex align-items-center" href="notifications.php">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="far fa-bell"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500"><?php $date = date_create($nots['date_sent']); echo date_format($date,"F j, Y"); ?></div>
                    <?php echo $nots['notification']; ?>
                  </div>
                </a>
                  <?php
                }
                      }else {
                         
                          ?>
                          <div align="center">
                          <p>You don't have any Notifications</p>
                          <i style="font-size: 20px;" class="fas fa-bell"></i>
                          </div> 
                          <?php
                      }
        ?>

                <a class="dropdown-item text-center small text-gray-500" href="notifications.php">Show All Notifications</a>
              </div>
            </li>

                        <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge <?php if($count_unread['message'] == 0){  ?>badge-primary<?php  }else{ ?>badge-danger<?php  } ?> badge-counter"><?php echo $count_unread['message'] ?></span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>

              <?php
                if(isset($unread) && count($unread)>0){
                    foreach($unread as $unreads){ ?>
                <a class="dropdown-item d-flex align-items-center" href="messages.php">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="../images/admin.png" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate"><?php echo $unreads['message']; ?>...</div>
                    <div class="small text-gray-500"><?php echo $unreads['username']; ?> · <?php $date = date_create($unreads['date_sent']); echo date_format($date,"d, M Y"); ?></div>
                  </div>
                </a>

                    <?php
                    }
                  }else {
                     
                      ?>
                      <div align="center">
                      <p>You don't have any Messages</p>
                      <i style="font-size: 20px;" class="fas fa-envelope"></i>
                      </div> 
                      <?php
                  }
                ?>

                <a class="dropdown-item text-center small text-gray-500" href="messages.php">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user_details['firstname'].' '.$user_details['lastname']; ?></span>
                <img class="img-profile rounded-circle" src="<?php if($user_details['picture'] == ''){ echo "../images/avatar.png"; }else{ echo $user_details['picture']; } ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->   <!-- Begin Page Content -->