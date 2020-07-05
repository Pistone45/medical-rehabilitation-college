    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          
        </div>
        <div class="sidebar-brand-text mx-3">MRC College</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->

      <!-- Nav Item - Grades Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsegrades" aria-expanded="true" aria-controls="collapsegrades">
          <i class="fas fa-graduation-cap"></i>
          <span>Grages</span>
        </a>
        <div id="collapsegrades" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Grades:</h6>
            <a class="collapse-item" href="filter-grades.php"><i class="fas fa-eye"></i> View Grades</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Materials Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsematerials" aria-expanded="true" aria-controls="collapsematerials">
          <i class="fas fa-book"></i>
          <span>Learning Materials</span>
        </a>
        <div id="collapsematerials" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Materials:</h6>
            <a class="collapse-item" href="filter-materials.php"><i class="fas fa-eye"></i> View Materials</a>
          </div>
        </div>
      </li>

      
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">


      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsemessages" aria-expanded="true" aria-controls="collapsemessages">
          <i class="fas fa-graduation-cap"></i>
          <span>Notifications/ Messages</span>
        </a>
        <div id="collapsemessages" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Grades:</h6>
            <a class="collapse-item" href="notifications.php"><i class="fas fa-bell"></i> View notifications</a>
            <a class="collapse-item" href="messages.php"><i class="fas fa-envelope"></i> View Messages</a>
          </div>
        </div>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->