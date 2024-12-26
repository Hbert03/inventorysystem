<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['personnel'])){
		echo '<script>window.open("index.php","_self")</script>';
	}else{
		include('fdatabase.php');
		include('ldnFunction.php');
		$admin_id = $_SESSION['personnel'];
		$userquery="select * from tbl_user as tu left join tbl_office as toff on tu.department = toff.office_id where user_id = '$admin_id'";
		$insQuery = mysqli_query($fconn2,$userquery);
		$rowQuery = mysqli_fetch_array($insQuery,MYSQLI_ASSOC);
		$userName = $rowQuery['office_name'];
	}
	if(isset($_GET['active'])){
		$office_id = $_GET['active'];
		$schoolDetails = new schoolDetails;
		
		echo $office_id;
		$schoolDetails -> setSchool($office_id);
		$schoolType = $schoolDetails -> school_type();
	}else{
		echo '<script>window.open("homepage.php","_self")</script>';
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
		<div class="preloader flex-column justify-content-center align-items-center">
    		<img class="animation__wobble" src="dist/img/depedlogo.png" alt="AdminLTELogo" style="border-radius:50%;" height="60" width="60">
 		</div>
		<!-- Navbar -->
		<?php include('sidemenu.php');?>
		  <!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<div class="content-header bg-lightblue mb-2">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-1 text-bold text-light" id="sectionHeader"><?php echo $schoolDetails -> schoolName()." - ".$schoolDetails -> districtName();?></h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
							  <li class="breadcrumb-item"><a href="homepage.php" class="text-light">Home</a></li>
							  <li class="breadcrumb-item active text-light">School</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<div class="small-box bg-info">
								<div class="inner">
									<p class='ml-2 text-lg text-bold'>SCHOOL DETAILS</p>
									<div class="container-fluid">
										<div class='row'>
											<div class='col-sm-6'>
												<p>SCHOOL HEAD:<span class='text-bold text-lg'> <?php echo $schoolDetails -> schoolHead();?></span></p>
											</div>
											<div class='col-sm-6'>
												<p>SCHOOL NAME (SCHOOL ID):<span class='text-bold text-lg'> <?php echo $schoolDetails -> schoolName()."(".$schoolDetails -> schoolId().")";?></span></p>
											</div>
										</div>
									</div>
									<div class="icon ">
										<i class="fas fa-school"></i>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<a href="#" onclick="testing123()">
							<div class="small-box bg-info">
								<div class="inner px-2">
									<h3>
										<?php
											echo $schoolDetails -> schPersonnelCount();
										?>
									</h3>
									<p>Numbers of Personnel</p>
									<div class="icon">
										<i class="fas fa-user-friends"></i>
									</div>
								</div>
								<a href="#" class="small-box-footer" onclick="showPersonnel()">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
							</a>
						</div>
						<div class="col-sm-3">
							<a href="#" onclick="testing123()">
							<div class="small-box bg-info">
								<div class="inner px-2">
									<h3>
										<?php
											$leaveArr =  $schoolDetails -> onLeave();
											echo count($leaveArr);
										?>
									</h3>
									<p>Personnel on leave</p>
									<div class="icon">
										<i class="fas fa-user-slash"></i>
									</div>
								</div>
								<a href="#" class="small-box-footer" onclick="showLeave()">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
							</a>
						</div>
						<!--<div class="col-sm-3">
							<a href="#" onclick="infoSection()">
							<div class="small-box bg-info">
								<div class="inner px-2">
									<h3>
										<?php
											//echo $schoolDetails -> sectionCount();
										?>
									</h3>
									<p>Numbers of section</p>
									<div class="icon">
										<i class="fab fa-buromobelexperte"></i>
									</div>
								</div>
								<a href="#" class="small-box-footer" onclick="showSection()">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
							</a>
						</div>-->
						<div class="col-sm-3">
							<!--<a href="#" onclick="infoSection()">
							<div class="small-box bg-info">
								<div class="inner px-2">
									<h3>
										<?php
											//echo $schoolDetails -> learnerCount();
										?>
									</h3>
									<p>Numbers of Learners</p>
									<div class="icon">
										<i class="fab fa-buromobelexperte"></i>
									</div>
								</div>
								<a href="#" class="small-box-footer" onclick="showSection()">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
							</a>-->
						</div>
						<div class="col-sm-3" id="recTeacherNoCont" style="display:none;">
							<!--<a href="#">
								<div class="small-box bg-warning">
									<div class="inner px-2">
										<h3 id="recTeacherNo">
											
										</h3>
										<p>Teacher Need Analysis</p>
										<div class="icon">
											<i class="fas fa-chalkboard-teacher"></i>
										</div>
									</div>
									<a href="#" class="small-box-footer" onclick="showTeacherAnalysis()">More info <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</a>-->
						</div>
						<?php 
						$admin_id = $_SESSION['personnel'];
						if($admin_id!=='347')
						{ ?>
						<div class="col-sm-6 mb-2">
							<button onclick="addEmployee(<?php echo $schoolDetails -> schoolId();?>)" class="btn btn-primary btn-block" ><i class="fas fa-user-plus mr-2"></i>ADD EMPLOYEE</button>
						</div>
						<?php
						}
						?>
						<div class="col-sm-6" id="hrisContainer">
							<div class="card">
								<div class="card-header text-center">
									<p class="text-bold text-lg">HRIS CREDENTIALS</p>
								</div>
								<div class="card-body">
									<form method="POST">
										<div class="row">
											<div class="col-sm-12">
												<label>USERNAME</label>
												<input class="form-control" name="username" value="<?php echo $schoolDetails -> getOls("username"); ?>" required>
												<label>OLS ACCOUNT</label>
												<select class="form-control" name='olsAcc'>
													<option value=''>Not Set</option>
													<?php
														echo $active = $schoolDetails -> getOls("active");

														if($active == 0){
															echo '<option value="'.$active.'" selected>Inactive</option>';
															echo '<option value="1">Active</option>';
														}else if($active == 1){
															echo '<option value="0">Inactive</option>';
															echo '<option value="'.$active.'" selected>Active</option>';
														}else{
															echo '<option value="0">Inactive</option>';
															echo '<option value="'.$active.'">Active</option>';
														}
													?>
												</select>
												<?php 
												$admin_id = $_SESSION['personnel'];
												if($admin_id!=='347')
												{ ?>
												<button type="submit" class="btn bg-olive btn-sm mt-2 float-right" name="updateols">UPDATE</button>
												<?php
												}
												?>
											</div>
											<div class="col-sm-6" >
												<label class="mt-2">PASSWORD</label>
												<?php
													$password = $schoolDetails -> getOls("password");
													if($password == md5("password")){
														echo "<h5 onmouseover='defaultPass()'>PASSWORD IS DEFAULT</h5>";
													}else{
														echo "<p class='text-center'>ACCOUNT HAS UPDATED PASSWORD</p>";
													$admin_id = $_SESSION['personnel'];
													if($admin_id!=='347')
														{ 
														echo '<button type="button" class="btn btn-block btn-sm btn-secondary" onclick="passwordResConf()">RESET <i class="fas fa-history ml-1"></i></button>';
														}
													}
												?>
											</div>
											<div class="col-sm-6" >
												<label class="mt-2">VALIDATION</label>
												<?php
													if($schoolDetails -> getOls("validation") == "2"){
														echo "<h5 class='text-center'>ACCOUNT IS VALIDATED</h5>";
													}else{
														echo "<h5 class='text-center'>ACCOUNT IS NOT VALIDATED</h5>";
													}
												?>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 mb-2" id="teacherAnalysis" style="display:none;">
					<div class="container-fluid">
						<header class="container">
							<a href="#" class='text-danger float-right' onclick='hideID("teacherAnalysis")'><i class="fas fa-window-close"></i></a>
						</header>
						<table class="table table-bordered table-hover text-center" id="ratioCalc">
							<thead>
								<tr>
									<th>GRADE LEVEL</th>
									<th>NUMBERS OF LEARNER</th>
									<th>TEACHER NEED ANALYSIS</th>
								</tr>
							</thead>
							<tbody>
								<?php
									function cntStudents($gradeLevel){
										require('fdatabase.php');
										$office_id = $_GET['active'];
										$tempQuery = "select count(*) as count from temp_enrollment left join school on school.schooltable_id = temp_enrollment.schooltable_id where temp_enrollment.temp_grade_level = '$gradeLevel' and school.school_id = '$office_id'";
										$currQuery = "select count(*) as count from current_enrollment left join section on section.section_id = current_enrollment.section_id left join school on school.schooltable_id = section.schooltable_id where school.school_id = '$office_id' and section.grade_level = '$gradeLevel'";
										$inscurrQuery = mysqli_query($fconn,$currQuery);
										$instempQuery = mysqli_query($fconn,$tempQuery);
										$tempRow = mysqli_fetch_array($instempQuery,MYSQLI_ASSOC);
										$currRow = mysqli_fetch_array($inscurrQuery,MYSQLI_ASSOC);
										$learnerCount = $tempRow['count']+$currRow['count'];
										return($learnerCount);
									}
									function calcTeacher($gradeLevel,$leanerCnt,$type){
										$localgradeLevel = $gradeLevel;
										$localleanerCnt = $leanerCnt;
										$localSectype = $type;
												
										if($localSectype = 'multigrade'){
											$recommendTeacher = ceil($localleanerCnt/25);
											return($recommendTeacher);
										}else{
											switch($localgradeLevel){
												case "K":
													$recommendTeacher = ceil($localleanerCnt/50);
													return($recommendTeacher);
													break;
												case "1":
													$recommendTeacher = ceil($localleanerCnt/30);
													return($recommendTeacher);
													break;
												case "2":
													$recommendTeacher = ceil($localleanerCnt/30);
													return($recommendTeacher);
													break;
												case "3":
													$recommendTeacher = ceil($localleanerCnt/30);
													return($recommendTeacher);
													break;
												case "4":
													$recommendTeacher = ceil($localleanerCnt/40);
													return($recommendTeacher);
													break;
												case ($localgradeLevel >= 5 && $localgradeLevel <= 10):
													$recommendTeacher = $localleanerCnt/40;
													$recommendedTeacher = ceil($recommendTeacher/3)*5;
													return($recommendedTeacher);
													break;
												case ($localgradeLevel >= 11):
													$recommendTeacher = $localleanerCnt/40;
													$recommendedTeacher = ceil($recommendTeacher/6)*9;
													return($recommendedTeacher);
													break;
												}
											}
										}
											
										$schoolId = $schoolDetails -> schoolId();
										$secQuery = "select distinct(section.grade_level),section.section_type from school left join section on section.schooltable_id = school.schooltable_id where school.school_id = '$schoolId'";
										$recommendedTeachers = 0;
										$secIns = mysqli_query($fconn,$secQuery);
										while($secRow = mysqli_fetch_array($secIns,MYSQLI_ASSOC)){
											$type =  $secRow['section_type'];
											$gradeLevel =  $secRow['grade_level'];
											$leanerCnt = cntStudents($secRow['grade_level']);
											$recommTeacher = calcTeacher($gradeLevel,$leanerCnt,$type);
											$recommendedTeachers = $recommendedTeachers + $recommTeacher;
											echo '<tr>
													<td>'.$gradeLevel.'</td>
													<td>'.$leanerCnt.'</td>
													<td>'.$recommTeacher.'</td>
												</tr>';
										}
										echo '<script>document.getElementById("recTeacherNo").innerHTML = "'.$recommendedTeachers.'"</script>';
									?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card" id="personnelTable" style="display:none;">
					<div class="card-header">
						<div><a href="#" class='text-danger float-right' onclick='hideID("personnelTable")'><i class="fas fa-window-close"></i></a><div class='text-center text-lg text-bold'>PERSONNEL LIST</div></div>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover maintable">
							<thead>
								<tr>
									<th>FULL NAME</th>
									<th>POSITION</th>
									<th>EMPLOYEE CLASSIFICATION</th>
									<th>USERNAME</th>
									<th>ACTIONS</th>
								</tr>
							</thead>
							<tbody>
								<?php
									
									$personnel = "select tbl_employee.hris_code,tbl_employee.position,tbl_employee.username,tbl_emp_classification.classification from tbl_employee left join tbl_office on tbl_office.id = tbl_employee.department_id left join tbl_emp_classification on tbl_emp_classification.id = tbl_employee.employee_classification where tbl_office.office_id = '$office_id'";
									$personnelIns = mysqli_query($fconn2,$personnel);
									
									while($personnelRow = mysqli_fetch_array($personnelIns,MYSQLI_ASSOC)){
										$name = getFullname($personnelRow['hris_code']);
									
									echo '<tr>
												<td>'.$name.'</td>
												<td>'.$personnelRow['position'].'</td>';
												if (strlen($personnelRow['classification']) == 0){
													echo '<td>Not Set</td>';
												}else{
													echo '<td>'.$personnelRow['classification'].'</td>';
												}
												echo '<td><button class="btn btn-danger btn-block btn-xs">EDIT</button></td>
											</tr>';
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