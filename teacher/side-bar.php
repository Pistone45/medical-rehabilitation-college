    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          
        </div>
        <div class="sidebar-brand-text mx-3">MRC</div>
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
            <a class="collapse-item" href="filter-grades.php"><i class="far fa-clipboard"></i> Add Grages</a>
            <a class="collapse-item" href="filter-view-grades.php"><i class="fas fa-binoculars"></i> View Grades</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsematerials" aria-expanded="true" aria-controls="collapsematerials">
          <i class="fas fa-book"></i>
          <span>Learning Materials</span>
        </a>
        <div id="collapsematerials" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Learning Materials:</h6>
            <a class="collapse-item" href="add-materials.php"><i class="fas fa-paperclip"></i> Add Materials</a>
            <a class="collapse-item" href="filter-materials.php"><i class="fas fa-binoculars"></i> View Materials</a>
          </div>
        </div>
      </li>

            <!-- Nav Item -Administration Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecal" aria-expanded="true" aria-controls="collapsecal">
          <i class="fas fa-calendar"></i>
          <span>Calendars</span>
        </a>
        <div id="collapsecal" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">MANAGE CALENDARS:</h6>
            <a class="collapse-item" href="exam-calendar.php"><i class="fas fa-calendar-check"></i> Exam Calendar</a> 
            <a class="collapse-item" href="timetable.php"><i class="fas fa-calendar-check"></i> Timetable</a>          
          </div>
        </div>
      </li>
      
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->