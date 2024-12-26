<!DOCTYPE html>
<?php
    session_start();
	if(!isset($_SESSION['admin'])){
		echo '<script>window.open("index.php","_self")</script>';
	}else{
        include('fdatabase.php');
        include("ldnFunction.php");
        $office_id = $_SESSION['admin'];
        $ofcQue = "select * from tbl_user where user_id = '$office_id'";
        $ofcIns = mysqli_query($fconn2,$ofcQue);
        $ofcRow = mysqli_fetch_array($ofcIns,MYSQLI_ASSOC);
		$office_id = $ofcRow['department'];
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
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container-fluid">
            <a href="homepage_sch.php" class="navbar-brand">
                <img src="dist/img/depedldn.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-bold">HRIS</span>
            </a>
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <a class="nav-link" onclick="logout()">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="content-wrapper">
        <!-- Content Header (Page header) 
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 ">Dashboard</small></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>-->
        <section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12 mt-2">
							<div class="card">
								<div class="row mx-2 my-2">
									<div class="col-6"><span class="">SCHOOL DETAILS</span></div>
									<?php
										if($office_id=='100004'){
										echo '<a href="inventory.php" class="navbar-brand float-right order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">';
										echo '<span class="brand-text font-weight-bold">Inventory</span></a>';
									}


									?>
									
									
								</div>
								
							</div>
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
						<div class="col-sm-6 col-lg-3">
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
						<div class="col-sm-6 col-lg-3">
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
						<div class="col-sm-6 col-lg-3" >
							<a href="#" onclick="infoSection()">
							<div class="small-box bg-info"  style="display:none;">
								<div class="inner px-2">
									<h3>
										<?php
											echo $schoolDetails -> learnerCount();
										?>
									</h3>
									<p>Numbers of Learners</p>
									<div class="icon">
										<i class="fab fa-buromobelexperte"></i>
									</div>
								</div>
								<a href="#" class="small-box-footer" onclick="showSection()">More info <i class="fas fa-arrow-circle-right"></i></a>
							</div>
							</a>
						</div>
						<div class="col-sm-6 col-lg-3" id="recTeacherNoCont" style="display:none;">
							<a href="#">
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
							</a>
						</div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="card" id="leaveTable" style="display:block;">
                                <div class="card-header">
                                    <div class='text-center text-lg text-bold'>PERSONNEL ON LEAVE</div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover nosearch">
                                        <thead>
                                            <tr>
                                                <th>FULL NAME</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $personOnleave = new Person();
                                                foreach($leaveArr as $hris){
                                                    $personOnleave -> setter($hris);
                                                    echo '<tr>
                                                            <td>'.$personOnleave -> getName('full').'<small>'.$personOnleave -> getPosition().'</small></td>
                                                        </tr>';
                                                    }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12">
                            <div class="card" id="personnelTable" style="display:block;">
                                <div class="card-header">
                                    <div><div class='text-center text-lg text-bold'>PERSONNEL LIST</div></div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover personnelTable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>FULL NAME</th>
                                                <th>POSITION</th>
                                                <th>EMPLOYEE CLASSIFICATION</th>
                                                <th>USERNAME</th>
                                                <th>PASSWORD</th>
                                                <th>VALIDATION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $personnel = "select tbl_employee.hris_code from tbl_employee left join tbl_office on tbl_office.id = tbl_employee.department_id left join tbl_emp_classification on tbl_emp_classification.id = tbl_employee.employee_classification where tbl_office.office_id = '$office_id'";
                                                $personnelIns = mysqli_query($fconn2,$personnel);
                                                while($personnelRow = mysqli_fetch_array($personnelIns,MYSQLI_ASSOC)){
                                                    $officePersonnel = new Person;
                                                    $officePersonnel -> setter($personnelRow['hris_code']);
                                                    echo '<tr>
                                                            <td>'.$officePersonnel->getName('full').'</td>
                                                            <td>'.$officePersonnel->getPosition().'</td>
                                                            <td>'.$officePersonnel->getRole().'</td>';
                                                            
                                                            echo '<td>'.$officePersonnel->getUsername().'</td>';
                                                            if(md5('password') == $officePersonnel ->getPassword()){
                                                                echo "<td><p class='text-center'>DEFAULT</p></td>";
                                                            }else{
                                                                echo '<td class=""><button class="btn btn-block btn-primary btn-sm" onclick="passwordResConf(\''.$officePersonnel->getName('full').'#jda#'.$personnelRow['hris_code'].'\')">RESET</button></td>';
															}
															$validity = $officePersonnel->getValidation();
															// echo '<td style=""><button class="btn btn-primary btn-block btn-sm"><span class="d-lg-block d-sm-none">EDIT</span><span class="d-lg-none d-sm-block"><i class="fas fa-edit d-lg-none d-sm-block"></i></span></button></td>';
															if($validity == '0'){
																echo '<td class="text-center" onmouseover="noAccess(\''.ucwords($officePersonnel->getName('full')).'\')">INACTIVE</td>';
															}else if($validity == '1'){
																echo '<td class=""><button class="btn btn-block btn-primary btn-sm" onclick="validate(\''.$officePersonnel->getName('full').'#jda#'.$personnelRow['hris_code'].'\')">VALIDATE</button></td>';
															}else{
																echo '<td class="text-center" onmouseover="validated(\''.ucwords($officePersonnel->getName('full')).'\')">VALIDATED</td>';
															}
															
                                                    echo '</tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
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
												//ceil() function is a built-in function in PHP and is used to round a number to the nearest greater integer.
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
        include("footer.php");
    ?>
    <script>
		function showTeacherAnalysis(){
			document.getElementById('teacherAnalysis').style.display = "block";
		}
		function showLeave(){
			document.getElementById('leaveTable').style.display = "block";
		}
		$(function (){
			$(".maintable").DataTable({
				"responsive": true,
				"autoWidth": false,
				
			});
			$(".personnelTable").DataTable({
				"scrollX":true,
				"scrollCollapse": true,
				"columnDefs": [
					{ "width":"50%", "targets": 0}
				],
				"fixedColumns":{
					"left": 1
				}
				// "width": "100%",
				
			});
			$(".nosearch").DataTable({
				"responsive": true,
				"autoWidth": false,
				"searching": false,
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
			
			document.getElementById("recTeacherNoCont").style.display="none";
			
		});
		function passwordResConf(val){
            var persDetails = val.split('#jda#');
			Swal.fire({
				icon:"warning",
				title:"Do you want to reset password?",
				html:"<p>This will reset the password to default. Password will be set to \"password\".</p>"+
                "<p class='text-center text-bold'><small>Name: </small>"+persDetails[0]+"</p>"+
				"<p><form method=\"POST\"><button type=\"submit\" class=\"btn btn-primary btn-sm btn-block\" name=\"passwordRes\" value=\""+persDetails[1]+"\">OKAY, SET PASSWORD TO DEFAULT</button><button type=\"button\" class=\"btn btn-secondary btn-sm btn-block\" onclick=\"Swal.close()\">CLOSE</button></form></p>",
				allowOutsideClick:false,
				showConfirmButton:false,
			})
		}
		function defaultPass(){
			toastr.error("Password is password","Password is already default")
		}
		function noAccess(val){
			toastr.warning(val+" is required to access OLS atleast once for validation","Access ols for validation")
		}
		function validated(val){
			toastr.success(val+" can access online leave system","Online Leave System")
		}
		function validate(val){
            var persDetails = val.split('#jda#');
			Swal.fire({
				title:"Online Leave System Account Validation",
				html:"<p>Do you want to validate this account?</p>"+
				"<p class='text-center text-bold'><small>Name: </small>"+persDetails[0]+"</p>"+
				"<p><form method=\"POST\"><button type=\"submit\" class=\"btn btn-primary btn-sm btn-block\" name=\"accValidation\" value=\""+persDetails[1]+"\">VALIDATE</button><button type=\"button\" class=\"btn btn-secondary btn-sm btn-block\" onclick=\"Swal.close()\">CLOSE</button></form></p>",
				allowOutsideClick:false,
				showConfirmButton:false,
			})
		}
        
	</script>
</body>
</html>
<?php
    if(isset($_POST['logoutButton'])){
		unset($_SESSION['admin']);
		echo '<script>window.open("index.php","_self")</script>';
	}
    if(isset($_POST['accValidation'])){
		$hris = $_POST['accValidation'];
		$updValidation = "update tbl_employee set validation = '2' where hris_code = '$hris'";
		if(mysqli_query($fconn2,$updValidation)){
			echo "<script>Swal.fire({
				icon:'success',
				title:'Online Leave Account Validation.',
				text:'Account is validated, this account can start using Online Leave System',
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
    if(isset($_POST['passwordRes'])){
		$hris = $_POST['passwordRes'];
		$defaultPass = md5("password");
		$updQuery = "update tbl_employee set password = '$defaultPass' where hris_code = '$hris'";
		
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
