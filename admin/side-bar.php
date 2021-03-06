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
        Users
      </div>

      <!-- Nav Item - Pages Collapse Menu -->

      <!-- Nav Item - Students Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-user-graduate"></i>
          <span>Students</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Students:</h6>
            <a class="collapse-item" href="add-student.php"><i class="fas fa-plus"></i> Add Student</a>
            <a class="collapse-item" href="view-students.php"><i class="fas fa-binoculars"></i> View Students</a>
          </div>
        </div>
      </li>

    <!-- Nav Item -Teachers Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseteachers" aria-expanded="true" aria-controls="collapseteachers">
          <i class="fas fa-user"></i>
          <span>Teachers</span>
        </a>
        <div id="collapseteachers" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Teachers:</h6>
            <a class="collapse-item" href="add-teacher.php"><i class="fas fa-plus"></i> Add Teacher</a>
            <a class="collapse-item" href="view-teachers.php"><i class="fas fa-binoculars"></i> View Teachers</a>
          </div>
        </div>
      </li>

      <!-- Nav Item -Accountant Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseaccountant" aria-expanded="true" aria-controls="collapseaccountant">
          <i class="fas fa-user"></i>
          <span>Accountants</span>
        </a>
        <div id="collapseaccountant" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Accountant:</h6>
            <a class="collapse-item" href="add-accountant.php"><i class="fas fa-plus"></i> Add Accountant</a>
            <a class="collapse-item" href="view-accountants.php"><i class="fas fa-binoculars"></i> View Accountants</a>
            <a class="collapse-item" href="view-fees-balances.php"><i class="fas fa-money-bill-wave"></i> View Fees Balances</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item -Administration Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsenoti" aria-expanded="true" aria-controls="collapsenoti">
          <i class="fas fa-bell"></i>
          <span>Notifications/ Messages</span>
        </a>
        <div id="collapsenoti" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">MANAGE NOTIFICATIONS:</h6>
            <a class="collapse-item" href="view-notifications.php"><i class="fas fa-bell-slash"></i> Send/View Notifications</a> 
            <a class="collapse-item" href="messages.php"><i class="fas fa-envelope"></i> View Messages</a>          
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
            <a class="collapse-item" href="exam-calendar.php"><i class="fas fa-calendar-plus"></i> Exam Calendar</a> 
            <a class="collapse-item" href="timetable.php"><i class="fas fa-calendar-plus"></i> Timetable</a>          
          </div>
        </div>
      </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsegrades" aria-expanded="true" aria-controls="collapsegrades">
          <i class="fas fa-graduation-cap"></i>
          <span>Grades</span>
        </a>
        <div id="collapsegrades" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manage Grades:</h6>
            <a class="collapse-item" href="filter-view-grades.php"><i class="fas fa-binoculars"></i> Edit Grades</a>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Nav Item -Administration Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseadmin" aria-expanded="true" aria-controls="collapseadmin">
          <i class="fas fa-cogs"></i>
          <span>Administration</span>
        </a>
        <div id="collapseadmin" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">CONTENT AND SETTINGS:</h6>
            <a class="collapse-item" href="the-team.php"><i class="fas fa-users"></i> The Team</a>
            <a class="collapse-item" href="classes.php"><i class="fab fa-buffer"></i> Classes</a>
            <a class="collapse-item" href="view-semesters.php"><i class="far fa-eye"></i> Semesters</a>            
            <a class="collapse-item" href="view-announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
          </div>
        </div>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->