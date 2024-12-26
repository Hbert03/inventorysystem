<?php
//	include('../../config/config_path.php');
?>
	 <!-- Sidebar Menu -->

	 
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="invent_home.php" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
				 <i class="right fas fa-angle-left"></i>
              </p>
            </a>
		  <ul class="nav nav-treeview">
			<li>
			<form method="post" class="active btn-info">
				<label for="buildingButton">				
				</label>
				<button type="button" name="buildingButton" class="btn btn-info no-outline left-aligned" data-toggle="modal" data-target="#addDataModal">
				Buildings and Structures
				</button><br>
				<label for="machineryButton">				
				</label>
				<button id="" name="machineryButton" class="btn btn-info no-outline left-aligned">
				Machinery and Equipment
				</button><br>
				<label for="transportButton">				
				</label>
				<button id="" name="transportButton" class="btn btn-info no-outline left-aligned">
				Transportation and Equipment
				</button><br>
				<label for="furnitureButton">				
				</label>
				<button id="" name="furnitureButton" class="btn btn-info no-outline left-aligned">
				Furniture Fixtures and Books
				</button><br>
				<label for="otherButton">				
				</label>
				<button id="" name="otherButton" class="btn btn-info no-outline left-aligned">
				Other Property Plant and<br>Equipment
				</button>
			</form>
			</li>
		  </ul>
		  </li><p>
		  <li>
			<form method="post" class="nav-link active">
				<label for="settingButton">				
				</label>
				<button id="" name="settingButton" class="btn btn-primary">
				Settings
				</button>

				<br>
				<label for="adminButton">				
				</label>
				<button id="" name="adminButton" class="btn btn-primary">
				Admin Settings
				</button>
			</form>
		  </li><br>
		  <li>
			<form method="post" class="nav-link active">
				<label for="logoutButton">				
				</label>
				<button id="" name="logoutButton" class="btn btn-primary">
				Log-out
				</button>
			</form>
		  </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Add form for adding data here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save Changes</button>
      </div>
    </div>
  </div>
</div>
  
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<style>
  .no-outline {
    border: none;
    outline: none;
	background-color:transparent;
  }
  .left-aligned {
    text-align: left;
</style>
<?php
	$custom_office = array('660','4');
	$tmp_user_id = $_SESSION['personnel'];
	if(isset($_POST['logoutButton'])){
		unset($_SESSION['personnel']);
		echo '<script>window.open("index.php","_self")</script>';
	}
	else if(isset($_POST['buildingButton'])){
		if(in_array($tmp_user_id,$custom_office )){
			$ams_button="select * from asset where asset_id = '1'";
			
		}else{
			$ams_button="select * from asset where asset_id = '1' and asset.user_id=$tmp_user_id";
		}
		$_SESSION['buttonDetails'] = $ams_button;
		$_SESSION['title'] = "Buildings And Structures";
		echo '<script>window.open("data.php","_self")</script>';
	}
	else if(isset($_POST['machineryButton'])){
		if(in_array($tmp_user_id,$custom_office )){
			$ams_button="select * from asset where asset_id = '2'";
			
		}else{
			$ams_button="select * from asset  where asset_id = '2' and asset.user_id=$tmp_user_id";
		}
		$_SESSION['buttonDetails'] = $ams_button;
		$_SESSION['title'] = "Machinery And Equipments";
		echo '<script>window.open("data.php","_self")</script>';
	}
	else if(isset($_POST['transportButton'])){
		if(in_array($tmp_user_id,$custom_office )){
			$ams_button="select * from asset where asset_id = '3'";
			
		}else{
			$ams_button="select * from asset  where asset_id = '3' and asset.user_id=$tmp_user_id";
		}
		$_SESSION['buttonDetails'] = $ams_button;
		$_SESSION['title'] = "Transportation And Equipments";
		echo '<script>window.open("data.php","_self")</script>';
	}
	else if(isset($_POST['furnitureButton'])){
		if(in_array($tmp_user_id,$custom_office )){
			$ams_button="select * from asset where asset_id = '4'";
			
		}else{
			$ams_button="select * from asset  where asset_id = '4' and asset.user_id=$tmp_user_id";
		}
		$_SESSION['buttonDetails'] = $ams_button;
		$_SESSION['title'] = "Furniture Fixtures And Books";
		echo '<script>window.open("data.php","_self")</script>';
	}
	else if(isset($_POST['otherButton'])){
		if(in_array($tmp_user_id,$custom_office )){
			$ams_button="select * from asset where asset_id = '5'";
			
		}else{
			$ams_button="select * from asset  where asset_id = '5' and asset.user_id=$tmp_user_id";
		}
		$_SESSION['buttonDetails'] = $ams_button;
		$_SESSION['title'] = "Other Property Plant And Equipments";
		echo '<script>window.open("data.php","_self")</script>';
	}
?>