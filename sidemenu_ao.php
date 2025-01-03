
    <style>
		a {
			cursor:pointer;
		}
		a:hover{
			background-color:skyblue;
		}
	</style>

<nav class="mt-2" id="sidebarNav1">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item ">
      <a href="invent_index.php" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
      </a>
    </li>
	<li class="nav-item ">
     <select class="form-control schools" id="school"></select>
    </li>
	<li class="nav-item">
	<a href="list.php" class="nav-link ">
	<i class="nav-icon fab fa-wpforms"></i>
        <p>Schools Entry</p>
      </a>
    </li>
  </ul>
</nav>
	<!-- <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

			 
			<li class="nav-item menu">
				<a href="invent_home.php" class="nav-link ">
				<i class="nav-icon fas fa-tachometer-alt"></i>
				<p>Admin Module
				<i class="right fas fa-angle-left"></i>
				</p></a>
				<ul class="nav nav-treeview">
					<form method="post">
					<li class="nav-item">
					<a href="land.php" class="nav-link left-aligned">
					<p><span><i class="fas fa-mountain"></i></span> Land</p>
					</a>
					</li>
					<li class="nav-item">
					<a class="nav-link left-aligned">
					<p><i class="fas fa-building"></i> Buildings and Structures</p>
					</a>
						<ul class="nav nav-treeview">
						  <li class="nav-item">
								<a href="build1.php" class="nav-link no-outline left-aligned">
								<i class="fas fa-toolbox nav-icon"></i>
								Office Buildings
								</a>
						  </li>
						  <li class="nav-item">
								<a href="build2.php"  class="nav-link no-outline left-aligned">
								<i class="fas fa-toolbox nav-icon"></i>
								Other Structures
								</a>
						  </li>
						  <li class="nav-item">
								<a href="build3.php"  class="nav-link no-outline left-aligned">
								<i class="fas fa-toolbox nav-icon"></i>
								School Buildings
								</a>
						  </li>
						</ul>
					</li>
					<li class="nav-item">
					<a id="" name="machEquipButton" class="nav-link left-aligned">
					<p><i class="fas fa-toolbox"></i> Machinery and Equipment</p>
					</a>
						<ul class="nav nav-treeview">
						  <li class="nav-item">
								<a  class="nav-link no-outline left-aligned" href="data1.php">
								<i class="fas fa-toolbox nav-icon"></i>
								Agricultural & Forestry<br>Equipment
								</a>
						  </li>
						  <li class="nav-item">
								<a  class="nav-link no-outline left-aligned" href="data2.php">
								<i class="fas fa-toolbox nav-icon"></i>
								ICT Equipment
								</a>
						  </li>
						  <li class="nav-item">
								<a class="nav-link no-outline left-aligned" href="data3.php">
								<i class="fas fa-toolbox nav-icon"></i>
								Machinery
								</a>
						  </li>
						<li class="nav-item">
								<a id="" class="nav-link no-outline left-aligned" href="data.php">
								<i class="fas fa-toolbox nav-icon"></i>
								Office Equipment
								</a>							
						  </li>
						<li class="nav-item">
								<a  class="nav-link no-outline left-aligned" href="data4.php">
								<i class="fas fa-toolbox nav-icon"></i>
								School Sports<br>Equipment
								</a>
						  </li>
						<li class="nav-item">
								<a  class="nav-link no-outline left-aligned" href="data5.php">
								<i class="fas fa-toolbox nav-icon"></i>
								Technical & Scientific<br>Equipment
								</a>
						  </li>
						</ul>
					</li>
					<li class="nav-item">
					<a id="" href="transportation.php" name="transportButton" class="nav-link left-aligned">
					<p><i class="fas fa-car-side"></i> Transportation and Equipment
					</p>
					</a>
					</li>
					<li class="nav-item">
					<a id="" name="furnBooButton" class="nav-link left-aligned">
					<p><i class="fas fa-book-open"></i> Furniture and Books</p>
					</a>
						<ul class="nav nav-treeview">
						  <li class="nav-item">
								<a href="book.php" id="" name="booksButton" class="nav-link no-outline left-aligned">
								<i class="fas fa-toolbox nav-icon"></i>
								Books
								</a>
						  </li>
						  <li class="nav-item">
								<a id="" href="furniture.php" name="furnitureButton" class="nav-link no-outline left-aligned">
								<i class="fas fa-toolbox nav-icon"></i>
								Furnitures and Fixtures
								</a>
						  </li>
						</ul>
					</li>
					<li class="nav-item">
					<a id=""href="others.php" name="otherButton" class="nav-link left-aligned">
					<i class="fas fa-seedling"></i> Other Property Plant and<br>Equipment
					</a>
					</li>
				</form>
			</ul>
			</li>
		  </li>
        </ul>
      </nav> -->
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

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
   .no-outline {
    border: none;
    outline: none;
	background-color:transparent;
  }
  .left-aligned {
    text-align: left;
  }
</style>
<?php
	// $custom_office = array('352','340');
	// if(isset($_SESSION['personnel'])) {
	// 	$tmp_user_id = $_SESSION['personnel'];
	// }else {
	// 	$tmp_user_id = $_SESSION['admin'];
	// }
	
	// if(isset($_POST['logoutButton'])){
	// 	if(isset($_SESSION['personnel'])) {
	// 		unset($_SESSION['personnel']);
	// 	}else {
	// 		unset($_SESSION['admin']);
	// 	}
	// 	echo '<scri>window.open("index.php","_self")</scri>';
	// }
	// else if(isset($_POST['buildstructButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '1'";
			
	// 	}else{
	// 		$ams_button="select * from asset where asset_id = '1' and user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '1';
	// 	$_SESSION['asset_subidDetails'] = '0';
	// 	$_SESSION['title'] = "Buildings and Structures";
	// 	echo '<script>window.open("data_build.php","_self")</script>';
	// }
	// else if(isset($_POST['officebuildButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '1' and asset_subid= '13'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '1' and asset_subid= '13' and user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '1';
	// 	$_SESSION['asset_subidDetails'] = '13';
	// 	$_SESSION['title'] = "Office Building";
	// 	echo '<script>window.open("data_build.php","_self")</script>';
	// }
	// else if(isset($_POST['buildingButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '1' and asset_subid= '1'";
			
	// 	}else{
	// 		$ams_button="select * from asset where asset_id = '1' and asset_subid= '1' and user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '1';
	// 	$_SESSION['asset_subidDetails'] = '1';
	// 	$_SESSION['title'] = "School Buildings";
	// 	echo '<script>window.open("data_build.php","_self")</script>';
	// }
	// else if(isset($_POST['structuresButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '1' and asset_subid= '2'";
			
	// 	}else{
	// 		$ams_button="select * from asset where asset_id = '1' and asset_subid= '2' and user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '1';
	// 	$_SESSION['asset_subidDetails'] = '2';
	// 	$_SESSION['title'] = "Other Structures";
	// 	echo '<script>window.open("data_build.php","_self")</script>';
	// }
	// else if(isset($_POST['machEquipButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '2'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '2' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '2';
	// 	$_SESSION['asset_subidDetails'] = '0';
	// 	$_SESSION['title'] = "Machinery and Equipment";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['machineryButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '2' and asset_subid= '3'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '2' and asset_subid= '3' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '2';
	// 	$_SESSION['asset_subidDetails'] = '3';
	// 	$_SESSION['title'] = "Machinery";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['officeButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '2' and asset_subid= '4'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '2' and asset_subid= '4' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '2';
	// 	$_SESSION['asset_subidDetails'] = '4';
	// 	$_SESSION['title'] = "Office Equipment";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['ictButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '2' and asset_subid= '5'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '2' and asset_subid= '5' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '2';
	// 	$_SESSION['asset_subidDetails'] = '5';
	// 	$_SESSION['title'] = "ICT Equipment";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['agricultureButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '2' and asset_subid= '6'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '2' and asset_subid= '6' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '2';
	// 	$_SESSION['asset_subidDetails'] = '6';
	// 	$_SESSION['title'] = "Agricultural & Forestry Equipment";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['sportsButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '2' and asset_subid= '7'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '2' and asset_subid= '7' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '2';
	// 	$_SESSION['asset_subidDetails'] = '7';
	// 	$_SESSION['title'] = "Sports Equipment";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['scientificButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '2' and asset_subid= '8'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '2' and asset_subid= '8' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '2';
	// 	$_SESSION['asset_subidDetails'] = '8';
	// 	$_SESSION['title'] = "Technical & Scientific Equipment";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['transportButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '3'  and asset_subid= '9'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '3'  and asset_subid= '9' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '3';
	// 	$_SESSION['asset_subidDetails'] = '9';
	// 	$_SESSION['title'] = "Motor Vehicle";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['furnBooButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '4'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '4' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '4';
	// 	$_SESSION['asset_subidDetails'] = '0';
	// 	$_SESSION['title'] = "Furnitures and Fixtures";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['furnitureButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '4' and asset_subid= '10'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '4' and asset_subid= '10' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '4';
	// 	$_SESSION['asset_subidDetails'] = '10';
	// 	$_SESSION['title'] = "Furnitures and Fixtures";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['booksButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '4' and asset_subid= '11'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '4' and asset_subid= '11' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '4';
	// 	$_SESSION['asset_subidDetails'] = '11';
	// 	$_SESSION['title'] = "Books";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['otherButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '5' and asset_subid= '12'";
			
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '5' and asset_subid= '12' and asset.user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '5';
	// 	$_SESSION['asset_subidDetails'] = '12';
	// 	$_SESSION['title'] = "Other Property Plant and Equipment";
	// 	echo '<script>window.open("data.php","_self")</script>';
	// }
	// else if(isset($_POST['landButton'])){
	// 	if(in_array($tmp_user_id,$custom_office )){
	// 		$ams_button="select * from asset where asset_id = '6'";
	// 	}else{
	// 		$ams_button="select * from asset  where asset_id = '6' and user_id=$tmp_user_id";
	// 	}
	// 	$_SESSION['buttonDetails'] = $ams_button;
	// 	$_SESSION['asset_idDetails'] = '6';
	// 	$_SESSION['asset_subidDetails'] = '14';
	// 	$_SESSION['title'] = "Land";
	// 	echo '<script>window.open("data_land.php","_self")</script>';
	// }
?>
