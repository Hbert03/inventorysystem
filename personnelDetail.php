<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['personnel'])){
		echo '<script>window.open("index.php","_self")</script>';
	}else{
		include('fdatabase.php');
		include('ldnFunction.php');
//		include('homepage.php');
		$admin_id = $_SESSION['personnel'];
		$userquery="select * from tbl_user as tu left join tbl_office as toff on tu.department = toff.office_id where user_id = '$admin_id'";
		$insQuery = mysqli_query($fconn2,$userquery);
		$rowQuery = mysqli_fetch_array($insQuery,MYSQLI_ASSOC);
		$userName = $rowQuery['office_name'];
	}
	if(isset($_GET['active'])){
		$office_id = $_GET['active'];
		$schoolDetails = new schoolDetails;
		$schoolDetails -> setSchool($office_id);
		$schoolType = $schoolDetails -> school_type();
		
	}
?>
<html lang="en">
	<head>
		<title>LDN | PORTAL</title>
		<link rel="icon" href="dist/img/depedldn.png">
		<?php include('header.php');?>
	</head>
	<style>
		#finishedtask,
		#ongoingtask{
			display:none;
		}
		::-webkit-scrollbar {
		  width: 5px;
		  background: white;
		}

		/* Track */
		::-webkit-scrollbar-track {
		  box-shadow: inset 0 0 5px white; 
		  border-radius: 5px;
		}
		 
		/* Handle */
		::-webkit-scrollbar-thumb {
		  background: grey; 
		  border-radius: 5px;
		}

		/* Handle on hover */
		::-webkit-scrollbar-thumb:hover {
		  background: #17a2b8; 
		}
	</style>
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">
		<!-- <div class="preloader flex-column justify-content-center align-items-center"> -->
    		<!-- <img class="animation__wobble" src="dist/img/depedlogo.png" alt="AdminLTELogo" style="border-radius:50%;" height="60" width="60"> -->
 		<!-- </div> -->
		<!-- Navbar -->
		<?php include('sidemenu.php');?>
		  <!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<section class="content">
								
				<div class="card" id="personnelTable" >
					<div class="card-header">
						<div><a href="#" class='text-danger float-right' onclick='hideID("personnelTable")'><i class="fas fa-window-close"></i></a><div class='text-center text-lg text-bold'>
									<?php
										$title = $_SESSION['title'];
										echo $title;
										?>
						</div></div>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover maintable">
							<thead>
								<tr>
									<th>SCHOOL ID</th>
									<th>SCHOOL</th>
									<th>FULL NAME</th>
									<th>POSITION</th>
									<th>SALARY GRADE</th>
									<th>USERNAME</th>
								</tr>
							</thead>
							<tbody>
								<?php
								
									$personnelDetails = $_SESSION['personnelDetails'];
									$personnel = $personnelDetails;
									$personnelIns = mysqli_query($fconn2,$personnel);
									//echo $personnelDetails;
									while($personnelRow = mysqli_fetch_array($personnelIns,MYSQLI_ASSOC)){
										$name = getFullname($personnelRow['hris_code']);
									if($personnelRow['employee_classification']=='0'){
									echo '<tr>
												<td>'.$personnelRow['office_id'].'</td>
												<td>'.$personnelRow['office_name'].'</td>
												<td>'.$name.'</td>
												<td>'.$personnelRow['position'].'</td>
												<td>'.$personnelRow['salary_grade'].'</td>
												<td>'.$personnelRow['username'].'</td>
												
											</tr>';
									}else
									{
									echo '<tr>
												<td>'.$personnelRow['office_id'].'</td>
												<td>'.$personnelRow['office_name'].'</td>
												<td>'.$name.'</td>
												<td>'.$personnelRow['position'].'</td>
												<td>'.$personnelRow['salary_grade'].'</td>
												<td>'.$personnelRow['username'].'</td>
												
												
											</tr>';
									}
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card" id="leaveTable" style="display:none;">
					<div class="card-header">
						<div><a href="#" class='text-danger float-right' onclick='hideID("leaveTable")'><i class="fas fa-window-close"></i></a><div class='text-center text-lg text-bold'>PERSONNEL ON LEAVE</div></div>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover maintable">
							<thead>
								<tr>
									<th>FULL NAME</th>
									<th>POSITION</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$personOnleave = new Person();
									foreach($leaveArr as $hris){
										$personOnleave -> setter($hris);
										echo '<tr>
												<td>'.$personOnleave -> getName('full').'</td>
												<td>'.$personOnleave -> getPosition().'</td>
											</tr>';
										}
								?>
							</tbody>
						</table>
					</div>
					
				</div>
				<div class="card" id="sectionTable" style="display:none;">
					<div class="card-header">
						<div><a href="#" class='text-danger float-right' onclick='hideID("sectionTable")'><i class="fas fa-window-close"></i></a><div class='text-center text-lg text-bold'>SECTION LIST</div></div>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover maintable">
							<thead>
								<tr>
									<th>SECTION NAME</th>
									<th>GRADE LEVEL</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$section = "select * from section left join school on school.schooltable_id = section.schooltable_id where school.school_id='$office_id'";
									$sectionIns = mysqli_query($fconn,$section);
									
									while($sectionRow = mysqli_fetch_array($sectionIns,MYSQLI_ASSOC)){
									
									echo '<tr>
												<td>'.$sectionRow['section_name'].'</td>
												<td>'.$sectionRow['grade_level'].'</td>
											</tr>';
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- <div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">
						<i class="far fa-chart-bar"></i>
						Donut Chart
						</h3>

						<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
						</div>
					</div>
					<div class="card-body">
						<div id="donut-chart" style="height: 300px;"></div>
					</div>
					/.card-body
				</div>-->
			</section>
		</div>
		<footer class="main-footer">
			<div class="float-right d-none d-sm-inline">
				LDN-PORTAL
			</div>
		<strong>Copyright &copy; <?php echo date('Y');?> <a href="https://depedldn.com">DIVISION-ICT</a>.</strong> All rights reserved.
		</footer>
		</div>
		
		<?php
			include('footer.php');
		?>
		<script>
		$(document).ready(function(){
			document.getElementById('schoolButton').className = "nav-link active";
		});
		function showTeacherAnalysis(){
			document.getElementById('teacherAnalysis').style.display = "block";
		}
		function showLeave(){
			document.getElementById('leaveTable').style.display = "block";
		}
		function passwordResConf(){
			Swal.fire({
				icon:"error",
			});
		}
		$(function (){
			$(".maintable").DataTable({
				"responsive": true,
				"autoWidth": false,
				
			});
			$("#ratioCalc").DataTable({
				"responsive": true,
				"autoWidth": false,
				"searching": false,
				"paging":true,
				"ordering": false,
				"pageLength": 7,
			});
		});	
		function logout(){
			Swal.fire({
				icon:"warning",
				title:"ARE YOU SURE YOU WANT TO LOGOUT?",
				showConfirmButton: false,
				html: "<form method='POST'><button class='btn btn-m btn-info btn-block' name='logoutButton'>YES, LOG ME OUT</button><a class='btn btn-m btn-danger btn-block' onclick='Swal.close()'>NO, KEEP ME LOGGED IN</a></form>",
			})
		}
		function showPersonnel(){
			document.getElementById('personnelTable').style.display = "block";
		}
		function showSection(){
			document.getElementById('sectionTable').style.display = "block";
		}
		function hideID(val){
			document.getElementById(val).style.display='none';
			
		}
		function infoSection(){
			Swal.fire({
				icon:"info",
				title:"SECTION",
				text: "This data is extracted from the DepEdLDN Enrollment System.",
				showConfirmButton:false,
				showCloseButton:true,
			})
		}
		function addEmployee(sch_id){
			window.open("empinsert.php?active="+sch_id,"_self");
		}
		$("#ratioCalc").ready(function(){
			
			document.getElementById("recTeacherNoCont").style.display="block";
			
		});
		function passwordResConf(){
			Swal.fire({
				icon:"warning",
				title:"Do you want to reset password?",
				html:"<p>This will reset the password to default. Password will be set to \"password\".</p>"+
				"<p><form method=\"POST\"><button type=\"submit\" class=\"btn btn-primary btn-sm btn-block\" name=\"passwordRes\">OKAY, SET PASSWORD TO DEFAULT</button><button type=\"button\" class=\"btn btn-secondary btn-sm btn-block\" onclick=\"Swal.close()\">CLOSE</button></form></p>",
				allowOutsideClick:false,
				showConfirmButton:false,
			})
		}
		function defaultPass(){
			toastr.error("Password is password","Password is already default")
		}
		</script>
	</body>
</html>
<?php
	if(isset($_POST['logoutButton'])){
		unset($_SESSION['personnel']);
		echo '<script>window.open("index.php","_self")</script>';
	}
	if(isset($_POST['updateols'])){
		$department = $schoolDetails -> schoolId();
		$username = $_POST['username'];
		$active = $_POST['olsAcc'];
		if($active == '1'){
			$activeStr = "Active";
		}else{
			$activeStr = "Inactive";
		}

		$updQue = "update tbl_user set username = '$username',active = '$active' where department = '$department'";

		if(mysqli_query($fconn2,$updQue)){
			echo '<script>
					Swal.fire({
						icon:"success",
						title:"You have updated office account",
						html:"<p>Username is \''.$username.'\'</p>"+
						"<p>Online leave school account is \''.$activeStr.'\'</p>"+
						"<p><button type=\"button\" class=\"btn btn-block btn-secondary btn-sm\" onclick=\"swal.close()\">CLOSE</button></p>",
						allowOutsideClick:false,
						showConfirmButton:false,
					}).then(()=>{
						var x = location.href;
						    x = x.split("#");
						window.open(x[0],"_self")
					})
			</script>';
		}else{
			echo '<script>
					Swal.fire({
						icon:"error",
						title:"Server Error",
						html:"Something went wrong with the server."+
						"<p><button type=\"button\" class=\"btn btn-block btn-secondary btn-sm mt-2\" onclick=\"swal.close()\">CLOSE</button></p>",
						allowOutsideClick:false,
						showConfirmButton:false,
					}).then(()=>{
						var x = location.href;
						    x = x.split("#");
						window.open(x[0],"_self")
					})
			</script>';
		}
	}
	if(isset($_POST['passwordRes'])){
		$hris = $_GET['active'];
		$defaultPass = md5("password");
		$updQuery = "update tbl_user set password = '$defaultPass' where department = '$hris'";
		if(mysqli_query($fconn2,$updQuery)){
			echo "<script>Swal.fire({
				icon:'success',
				title:'Password is set to default.',
				text:'Password is now \"password\"',
				allowClickOutside:false,
				showConfirmButton:false,
			}).then(()=>{
				var x = location.href;
					x = x.split('#');
				window.open(x[0],'_self')
			})</script>";
		}else{
			echo "<script>Swal.fire({
				icon:'error',
				title:'Something went wrong',
				html:'<p>Something went wrong with the server.</p><p><button class=\"btn btn-block btn-secondary btn-sm\" onclick=\"swal.close()\">CLOSE</button></p>',
				allowOutsideClick:false,
				showConfirmButton:false,
			}).then(()=>{
				var x = location.href;
					x = x.split('#');
				window.open(x[0],'_self')
			})</script>";
		}
		
	}

?>