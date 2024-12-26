
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/DEPEDLOGO.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">
          <?php
          if (isset($_SESSION['employee_name'])) {
              echo $_SESSION['employee_name'];  
             
          } else {
              echo $_SESSION['school'];  
          }
          ?>
        </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->

