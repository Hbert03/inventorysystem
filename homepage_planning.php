<!DOCTYPE html>
<?php
    session_start();
	if(!isset($_SESSION['planning'])){
		echo '<script>window.open("index.php","_self")</script>';
	}else{
        include('fdatabase.php');
        include("ldnFunction.php");
        $office_id = $_SESSION['planning'];
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
        <div class="content-header">
		  <div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">HOME</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item text-center">Home</li>
					</ol>
				</div>
			</div>
		  </div>
		</div>
        <section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12 mt-2">
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
						<div class="col-sm-3">
							<a href="enrollment_view.php" class="btn bg-teal btn-block btn-sm mb-1 text-bold">ENROLLMENT VIEW <i class="fas fa-file-upload ml-1"></i></a>
						</div>
						<div class="col-sm-3">
							<a href="enrollment_planning.php" class="btn bg-teal btn-block mb-1 btn-sm text-bold">ELEMENTARY ENROLLMENT UPLOADING <i class="fas fa-file-upload ml-1"></i></a>
							<a href="enrollmentjhs_planning.php" class="btn btn-primary btn-block mb-1 btn-sm text-bold">JHS ENROLLMENT UPLOADING <i class="fas fa-file-upload ml-1"></i></a>
							<a href="enrollmentshs_planning.php" class="btn btn-danger btn-block mb-1 btn-sm text-bold">SHS ENROLLMENT UPLOADING <i class="fas fa-file-upload ml-1"></i></a>
						</div>
                        <div class="col-sm-4">
							
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
                        <div class="col-sm-8">
                            <div class="card" id="personnelTable" style="display:block;">
                                <div class="card-header">
                                    <div class='text-center text-lg text-bold'>PERSONNEL LIST</div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover maintable">
                                        <thead>
                                            <tr>
                                                <th>FULL NAME</th>
                                                <th>POSITION</th>
                                                <th>EMPLOYEE CLASSIFICATION</th>
                                                <th>USERNAME</th>
                                                <th>PASSWORD</th>
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
                                                                echo "<td><p class='text-center'>PASSWORD IS DEFAULT</p></td>";
                                                            }else{
                                                                echo '<td class=""><button class="btn btn-block btn-primary btn-sm" onclick="passwordResConf(\''.$officePersonnel->getName('full').'#jda#'.$personnelRow['hris_code'].'\')">RESET PASSWORD</button></td>';
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
		function showLeave(){
			document.getElementById('leaveTable').style.display = "block";
		}
		$(function (){
			$(".maintable").DataTable({
				"responsive": true,
				"autoWidth": false,
				
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
		function hideID(val){
			document.getElementById(val).style.display='none';
			
		}
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
        
		</script>
</body>
</html>
<?php
    if(isset($_POST['logoutButton'])){
		unset($_SESSION['planning']);
		echo '<script>window.open("index.php","_self")</script>';
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
