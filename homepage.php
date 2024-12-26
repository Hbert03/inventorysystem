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
			$insQuery = mysqli_query($fconn,$userquery);
			$rowQuery = mysqli_fetch_array($insQuery,MYSQLI_ASSOC);
			$userName = $rowQuery['office_name'];
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
		  <!-- Navbar -->
		<?php include('sidemenu.php');?>
		  <!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<div class="content-header bg-lightblue mb-2">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-12">
							<h1 class="m-0 text-bold" id="sectionHeader">MY DASHBOARD</h1>
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container-fluid" id="dashboard">
					<div class="row d-flex">
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-gradient-warning">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_office where office_type = '1'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWnonteachingCounter['count']);
										?>
									</h3>
									<p>Primary School</p>
								</div>
								<div class="icon">
									<i class="fas fa-user-friends"></i>
								</div>
								<form method="post">
									<button class="btn btn-block btn-warning btn-sm" id="" name="primaryButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-primary">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_office where office_type = '2'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWnonteachingCounter['count']);
										?>
									</h3>
									<p>Elementary School</p>
								</div>
								<div class="icon">
									<i class="fas fa-user-friends"></i>
								</div>
								<form method="post">
									<button class="btn btn-block btn-primary btn-sm" id="" name="elementaryButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_office where office_type = '3'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWnonteachingCounter['count']);
										?>
									</h3>
									<p>Secondary School</p>
								</div>
								<div class="icon">
									<i class="fas fa-user-friends"></i>
								</div>
								<form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="secondaryButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_office where office_type = '4'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWnonteachingCounter['count']);
										?>
									</h3>
									<p>Integrated School</p>
								</div>
								<div class="icon">
									<i class="fas fa-user-friends"></i>
								</div>
								<form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="integratedButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-gradient-warning">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification = '1' and Active ='1'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWnonteachingCounter['count']);
										?>
									</h3>
									<p>Total Numbers of Teaching Personnel</p>
								</div>
								<div class="icon">
									<i class="fas fa-user-friends"></i>
								</div>
								<form method="post">
									<button class="btn btn-block btn-warning btn-sm" id="" name="teachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-primary">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification = '1' and Active='1' and employment_status not in ('Regular Permanent','Permanent','Regular','')";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);

											echo number_format($ROWnonteachingCounter['count']);
										?>
									</h3>
									<p>Provisional Teaching Personnel</p>
								</div>
							  <div class="icon">
									
									
									<i class="fas fa-user-tie"></i>
										
							  </div>
								<form method="post">
									<button class="btn btn-block btn-primary btn-sm" id="" name="provteachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification = '1' and Active='1' And employment_status in ('Regular Permanent','Permanent','Regular')";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWteachingCounter['count']);
										?>
									</h3>
									<p>Regular Teaching Personnel</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="regteachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification = '1' and Active='1' And employment_status=''";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWteachingCounter['count']);
											
										?>
									</h3>
									<p>No-status Teaching Personnel</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="nostatteachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-gradient-warning">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification = '2' and Active ='1'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											
											echo number_format($ROWnonteachingCounter['count']);
											
										?>
									</h3>
									<p>Non-Teaching Personnel</p>
								</div>
							  <div class="icon">
									<i class="fas fa-user-friends"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-warning btn-sm" id="" name="nonteachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-primary">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification = '2' and Active='1' and employment_status not in ('Regular Permanent','Permanent','')";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											
											echo number_format($ROWnonteachingCounter['count']);
											
										?>
									</h3>
									<p>Job Order Non-teaching Personnel</p>
								</div>
							  <div class="icon">
									<i class="fas fa-user-tie"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-primary btn-sm" id="" name="jononteachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification = '2' and Active='1' And employment_status in ('Regular Permanent','Permanent')";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWteachingCounter['count']);
											
										?>
									</h3>
									<p>Regular Non-teaching Personnel</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="regnonteachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification = '2' and Active='1' And employment_status=''";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWteachingCounter['count']);
											

										?>
									</h3>
									<p>No-status Non-teaching Personnel</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="nostatnonteachingButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-gradient-warning">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification = '3' and Active ='1'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											
											echo number_format($ROWnonteachingCounter['count']);
											
										?>
									</h3>
									<p>Total School Head Personnel</p>
								</div>
							  <div class="icon">
									<i class="fas fa-user-friends"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-warning btn-sm" id="" name="schoolheadButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
						<div class="small-box bg-primary">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification = '3' and Active='1' and (position like 'master%' or position  like 'teacher%')";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWnonteachingCounter['count']);
											
										?>
									</h3>
									<p>SH without Item</p>
								</div>
							  <div class="icon">
									<i class="fas fa-user-tie"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-primary btn-sm" id="" name="shwtoutButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification = '3' and Active='1' And position like '%head teacher%'";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWteachingCounter['count']);
											
										?>
									</h3>
									<p>Head Teacher</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="headteachButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification = '3' and Active='1' And position like '%principal%'";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWteachingCounter['count']);
											
										?>
									</h3>
									<p>Assistant and School Principal</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="principalButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
						
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-gradient-warning">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification ='5' and active ='1'";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWteachingCounter['count']);
											
										?>
									</h3>
									<p>Division Section Head</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-warning btn-sm" id="" name="sectionheadButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-primary">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification in ('4','10') and active ='1' and position not like '%supervisor%'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											echo number_format($ROWnonteachingCounter['count']);
											
										?>
									</h3>
									<p>Supervisors without item</p>
								</div>
							  <div class="icon">
									<i class="fas fa-user-friends"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-primary btn-sm" id="" name="supwoutButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$nonteachingCounter = "select count(*) as count from tbl_employee where employee_classification in ('4','10') and active ='1' and position like '%supervisor%'";
											$insnonteachingCounter = mysqli_query($fconn2,$nonteachingCounter);
											$ROWnonteachingCounter = mysqli_fetch_array($insnonteachingCounter,MYSQLI_ASSOC);
											
											
											echo number_format($ROWnonteachingCounter['count']);
										?>
									</h3>
									<p>Supervisors with item</p>
								</div>
							  <div class="icon">
									<i class="fas fa-user-tie"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="superButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						<div class="col-3">
						<!-- small box -->
							<div class="small-box bg-success">
								<div class="inner">
									<h3>
										<?php
											$teachingCounter = "select count(*) as count from tbl_employee where employee_classification in ('6','7') and active ='1'";
											$insteachingCounter = mysqli_query($fconn2,$teachingCounter);
											$ROWteachingCounter = mysqli_fetch_array($insteachingCounter,MYSQLI_ASSOC);
											
											
											echo number_format($ROWteachingCounter['count']);
										?>
									</h3>
									<p>Chief</p>
								</div>
							  <div class="icon">
									<i class="fas fa-chalkboard-teacher"></i>
							  </div>
							  <form method="post">
									<button class="btn btn-block btn-success btn-sm" id="" name="chiefButton">
										View All <i class="fas fa-arrow-circle-right ml-1"></i>
									</button>
								</form>
							</div>
							
						</div>
						</div>
					</div>
				
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
			document.getElementById('homepageButton').className = "nav-link active"
		})
		function logout(){
			Swal.fire({
				icon:"warning",
				title:"ARE YOU SURE YOU WANT TO LOGOUT?",
				showConfirmButton: false,
				html: "<form method='POST'><button class='btn btn-m btn-info btn-block' name='logoutButton'>YES, LOG ME OUT</button><a class='btn btn-m btn-danger btn-block' onclick='Swal.close()'>NO, KEEP ME LOGGED IN</a></form>",
					})
			}
		</script>	
	</body>
</html>
<?php
	if(isset($_POST['logoutButton'])){
		unset($_SESSION['personnel']);
		echo '<script>window.open("index.php","_self")</script>';
	}
	else if(isset($_POST['teachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '1' and Active ='1'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "List of Teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['primaryButton'])){
		$schoolSelect="select tbl_office.*,tbl_district.*,tbl_school_type.*,tbl_office.id as officetable_id from tbl_office
			join tbl_district on tbl_district.id=tbl_office.district 
			join tbl_school_type on tbl_school_type.id = tbl_office.office_type
			where tbl_office.office_type='1'";
		$_SESSION['personnelDetails'] = $schoolSelect;
		$_SESSION['teacherCount'] = $teacherCount;
		$_SESSION['title'] = "PRIMARY SCHOOLS";
		echo '<script>window.open("schoolsDetail.php","_self")</script>';
	}
	else if(isset($_POST['elementaryButton'])){
		$schoolSelect="select tbl_office.*,tbl_district.*,tbl_school_type.*,tbl_office.id as officetable_id from tbl_office
			join tbl_district on tbl_district.id=tbl_office.district 
			join tbl_school_type on tbl_school_type.id = tbl_office.office_type
			where tbl_office.office_type='2'";
		$_SESSION['personnelDetails'] = $schoolSelect;
		$_SESSION['teacherCount'] = $teacherCount;
		$_SESSION['title'] = "ELEMENTARY SCHOOL";
		echo '<script>window.open("schoolsDetail.php","_self")</script>';
	}
	else if(isset($_POST['secondaryButton'])){
		$schoolSelect="select tbl_office.*,tbl_district.*,tbl_school_type.*,tbl_office.id as officetable_id from tbl_office
			join tbl_district on tbl_district.id=tbl_office.district 
			join tbl_school_type on tbl_school_type.id = tbl_office.office_type
			where tbl_office.office_type='3'";
		$_SESSION['personnelDetails'] = $schoolSelect;
		$_SESSION['teacherCount'] = $teacherCount;
		$_SESSION['title'] = "SECONDARY SCHOOLS";
		echo '<script>window.open("schoolsDetail.php","_self")</script>';
	}
	else if(isset($_POST['integratedButton'])){
		$schoolSelect="select tbl_office.*,tbl_district.*,tbl_school_type.*,tbl_office.id as officetable_id from tbl_office
			join tbl_district on tbl_district.id=tbl_office.district 
			join tbl_school_type on tbl_school_type.id = tbl_office.office_type
			where tbl_office.office_type='4'";
		$_SESSION['personnelDetails'] = $schoolSelect;
		$_SESSION['teacherCount'] = $teacherCount;
		$_SESSION['title'] = "INTEGRATED SCHOOLS";
		echo '<script>window.open("schoolsDetail.php","_self")</script>';
	}
	else if(isset($_POST['provteachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '1' and Active='1' and employment_status not in ('Regular Permanent','Permanent','Regular','')";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Provisional Teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['regteachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '1' and Active='1' And employment_status in ('Regular Permanent','Permanent','Regular')";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Regular Teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['nostatteachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '1' and Active='1' And employment_status=''";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "No-status Teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['nonteachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '2' and Active ='1'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Non-Teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['jononteachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '2' and Active='1' and employment_status not in ('Regular Permanent','Permanent','')";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Job Order Non-teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['regnonteachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '2' and Active='1' And employment_status in ('Regular Permanent','Permanent')";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Regular Non-teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['nostatnonteachingButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '2' and Active='1' And employment_status=''";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "No-status Non-teaching Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['schoolheadButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '3' and Active ='1'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "List of School Head Personnel";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['shwtoutButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '3' and Active='1' and (position like 'master%' or position  like 'teacher%')";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "School Head without Item";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['headteachButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '3' and Active='1' And position like '%head teacher%'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Head Teachers";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['principalButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '3' and Active='1' And position like '%principal%'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Assistant and School Principals";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['sectionheadButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification = '5' and active ='1'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Division Section Head";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['supwoutButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification in ('4','10') and active ='1' and position not like '%supervisor%'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Supervisors without item";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['superButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification in ('4','10') and active ='1' and position like '%supervisor%'";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Supervisors with item";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
	else if(isset($_POST['chiefButton'])){
		$teaching="select * from tbl_employee JOIN tbl_office on tbl_office.id = tbl_employee.department_id where employee_classification  in ('6','7')";
		
		$_SESSION['personnelDetails'] = $teaching;
		$_SESSION['title'] = "Chief";
		echo '<script>window.open("personnelDetail.php","_self")</script>';
	}
?>
