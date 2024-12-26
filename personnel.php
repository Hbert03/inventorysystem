<!DOCTYPE html>
<?php
	session_start();
	if(!isset($_SESSION['personnel'])){
		echo '<script>window.open("index.php","_self")</script>';
	}else{
		include('fdatabase.php');
		$admin_id = $_SESSION['personnel'];
		$userquery="select * from tbl_user as tu left join tbl_office as toff on tu.department = toff.office_id where user_id = '$admin_id'";
		$insQuery = mysqli_query($fconn2,$userquery);
		$rowQuery = mysqli_fetch_array($insQuery,MYSQLI_ASSOC);
		$userName = $rowQuery['office_name'];
	}
	if(isset($_GET['active'])){
		include("ldnFunction.php");
		$person_hris = $_GET['active'];
		$person = new Person();
		$person -> setter($person_hris);
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
	<body class="hold-transition text-dark sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
		<div class="wrapper">
		  <!-- Navbar -->
		<?php include('sidemenu.php');?>
		  <!-- Content Wrapper. Contains pagecontent -->
		<div class="content-wrapper">
			<div class="content-header bg-lightblue mb-2">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-1 text-bold" id="sectionHeader">PERSONNEL DETAILS</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
							  <li class="breadcrumb-item"><a href="homepage.php" class="text-light">Home</a></li>
							  <li class="breadcrumb-item text-light active">Personnel Details</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container-fluid mb-2 text-bold">
					<p>HRIS CODE: <?php echo $_GET['active'];?></p>
					<p>OFFICE ID: <?php echo $person -> getDepartmentData("id");?></p>
					<p>OFFICE HEAD ID: <?php echo $person -> getDepartmentData("head");?></p>
				</div>
				<div class="container-fluid mb-2">
					<div class="row">
						<div class="col">
							<button type="button" class="btn btn-lg btn-dark btn-block" disabled>LOYALTY</button>
						</div>
						<div class="col">
							<button type="button" class="btn btn-lg btn-dark btn-block" disabled>EDUCATION</button>
						</div>
						<div class="col">
							<button type="button" class="btn btn-lg btn-dark btn-block" disabled>OTHER INFORMATION</button>
						</div>
					</div>
					
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
									<form method="POST">
										<div class="row">
												<div class="col-sm-4">
													<label>FIRST NAME</label>
													<input class="form-control" name="firstname" value = "<?php echo $person -> getName("firstname"); ?>" required/>
												</div>
												<div class="col-sm-2">
													<label>MIDDLE NAME</label>
													<input class="form-control" name="midname" value = "<?php echo $person -> getName("middlename"); ?>" required/>
												</div>
												<div class="col-sm-4">
													<label>LAST NAME</label>
													<input class="form-control" name="lastname" value = "<?php echo $person -> getName("lastname"); ?>" required/>
												</div>
												<div class="col-sm-2">
												<?php
												 	$extName = $person -> getName("extname");
													if (strpos(strtolower($extName), 'jr') !== false) {
														$extName = str_replace(".","",ucwords(strtolower($extName)));
														$extName = $extName.".";
													}
													if (strpos(strtolower($extName), 'sr') !== false) {
														$extName = str_replace(".","",ucwords(strtolower($extName)));
														$extName = $extName.".";
													}
													$extOpt = array(" ","II","III","IV","Jr.","Sr.");
													echo '<label>EXTENSION NAME</label>
															<select class="form-control" name="extname" id="extname">';
															foreach ($extOpt as $opt){
																if($extName == $opt){
																	echo '<option value="'.$opt.'" selected>'.$opt.'</option>';
																}else{
																	echo '<option value="'.$opt.'">'.$opt.'</option>';
																}
															}
														echo '</select>';
												?>
												</div>
												<div class="col-sm-3">
													<label>BIRTHDATE</label>
													<input type="date" class="form-control" name="bday" value = "<?php echo $person -> getBirthday(); ?>" required/>
												</div>
												<div class="col-sm-3">
													<?php
														$civil =  $person -> getCivilStatus();
														$civilStatArr = array("MARRIED","SINGLE","WIDOWED","SEPARATED","DIVORCED");
														echo '<label>CIVIL STATUS</label>
																<select class="form-control" name="cstatus" id="cstatus" required>';
														foreach ($civilStatArr as $stat){
															if($civil == $stat){
																echo '<option value="'.$stat.'" selected>'.$stat.'</option>';
															}else{
																echo '<option value="'.$stat.'">'.$stat.'</option>';
															}
														}
														echo '</select>';
													?>
												</div>
												<div class="col-sm-2">
													<label>BLOOD TYPE</label>
													<input class="form-control" name="bloodtype" value = "<?php echo $person -> getBloodtype(); ?>" required/>
												</div>
												<div class="col-sm-2">
													<?php
														$gender =  $person -> getGender();
														$genderOpt = array("F","M");
														echo '<label>GENDER</label>
																<select class="form-control" name="gender" id="gender" required/>';
														foreach ($genderOpt as $opt){
															if($gender == $opt){
																echo '<option value="'.$opt.'" selected>'.$opt.'</option>';
															}else{
																echo '<option value="'.$opt.'">'.$opt.'</option>';
															}
														}
														echo '</select>';
													?>
												</div>
												<div class="col-sm-2">
													<label>CONTACT</label>
													<input class="form-control" name="contact" value = "<?php echo $person -> getContact(); ?>" required/>
												</div>
										</div>
										<?php 
										$admin_id = $_SESSION['personnel'];
										if($admin_id!=='347')
										{ ?>
										<button type="submit" name="update1" class="btn btn-sm float-right mt-2 bg-olive">
											UPDATE
										</button><?php
										}
										?>
									</form>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="card">
								<div class="card-body">
								<form method="POST">
							<div class="row">
								<div class="col-sm-3">
									<label>EMPLOYEE NUMBER</label>
									<input class="form-control" name="emp_no" value = "<?php echo $person -> getEmployeenumber(); ?>" required/>
								</div>
								<div class="col-sm-3">
									<label>ITEM NUMBER</label>
									<input class="form-control" name="itemNo" value = "<?php echo $person -> getItemNo(); ?>" required/>
								</div>
								<div class="col-sm-3">
									<label>EMPLOYMENT STATUS</label>
									<input class="form-control" name="emp_stat" value = "<?php echo $person -> getEmploymentstatus(); ?>" required/>
								</div>
								<div class="col-sm-3">
									<label>ASSIGNMENT PLANTILLA</label>
									<input class="form-control" name="assPlantilla" value = "<?php echo $person -> assigntmentPlantilla(); ?>" readonly/>
								</div>
								<div class="col-sm-3">
									<label>SALARY GRADE</label>
									<input class="form-control" name="salary_grade" value = "<?php echo $person -> getSalarygrade(); ?>" required/>
								</div>
								<div class="col-sm-3">
									<label>SALARY STEP</label>
									<input class="form-control" name="salary_step" value = "<?php echo $person -> getSalarystep(); ?>" required/>
								</div>
								<div class="col-sm-3">
									<label>POSITION</label>
									<?php
										$basePost = $person->getPosition();
										$posQue = "select * from tbl_position";
										$postQueIns = mysqli_query($fconn2,$posQue);
										echo "<select class='form-control select2' name='position' required/>";
										while($posRow = mysqli_fetch_array($postQueIns,MYSQLI_ASSOC)){
											if($basePost == $posRow['position_description']){
												echo "<option value='".$posRow['position_description']."' selected>".$posRow['position_description']."</option>";
											}else{
												echo "<option value='".$posRow['position_description']."'>".$posRow['position_description']."</option>";
											}
										}
										echo "</select>";
									?>
								</div>
								<div class="col-sm-3">
									<label>OFFICE</label>
									<?php
										$baseDept = $person->getDepartment();
										$officeQue = "select * from tbl_office";
										$officeIns = mysqli_query($fconn2,$officeQue);
										echo "<select class='form-control select2' name='office' required/>";
										while($officeRow = mysqli_fetch_array($officeIns,MYSQLI_ASSOC)){
											if($baseDept == $officeRow['office_name']){
												echo "<option value='".$officeRow['id']."' selected>".$officeRow['office_name']." (".$officeRow['office_id'].")</option>";
											}else{
												echo "<option value='".$officeRow['id']."'>".$officeRow['office_name']." (".$officeRow['office_id'].")</option>";
											}
										}
										echo "</select>";
									?>
								</div>
								<div class="col-sm-3">
									<label>APPOINTMENT DATE</label>
									<input type="date" name="appointment_date" class="form-control" value = "<?php echo $person -> getAppointmentdate(); ?>" required/>
								</div>
								<div class="col-sm-3">
									<label>START DATE OF CONTINUED SERVICE</label>
									<input type="date" name="cont_service" class="form-control" value = "<?php echo $person ->getStartdatecontinuedservice(); ?>" required/>
								</div>
							</div>
							<?php 
							$admin_id = $_SESSION['personnel'];
							if($admin_id!=='347')
							{ ?>
							<button type="submit" name="update2" class="btn btn-sm float-right mt-2 bg-olive">UPDATE</button>
							<?php
							}
							?>
							</form>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<form method="POST">
										<div class="row">
											<div class="col-sm-6">
												<label>TIN</label>
												<input class="form-control" name="tin" value = "<?php echo $person -> getTin(); ?>">
											</div>
											<div class="col-sm-6">
												<label>GSIS</label>
												<input class="form-control" name="gsis" value = "<?php echo $person -> getGsis(); ?>">
											</div>
											<div class="col-sm-6">
												<label>SSS</label>
												<input class="form-control" name="sss" value = "<?php echo $person -> getSss(); ?>">
											</div>
											<div class="col-sm-6">
												<label>PHILHEALTH</label>
												<input class="form-control" name="philhealth" value = "<?php echo $person -> getPhilhealth(); ?>">
											</div>
										</div>
										<?php 
										$admin_id = $_SESSION['personnel'];
										if($admin_id!=='347')
										{ ?>
										<button type="submit" class="btn bg-olive btn-sm mt-2 float-right" name="update3">UPDATE</button>
										<?php
										}
										?>
									</form>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-body">
									<h3>ONLINE LEAVE SYSTEM CREDENTIALS</h3>
									<form method="post">
										<div class="row">
											<div class="col-sm-12">
												<label>USERNAME</label>
												<input class="form-control" name="username" value="<?php echo $person -> getUsername(); ?>" required>
												<label>EMPLOYEE CLASSIFICATION</label>
												<?php
												 	$baseRole = $person->getRole();
													$roleQue = "select * from tbl_emp_classification";
													$roleQueIns = mysqli_query($fconn2,$roleQue);
													echo "<select class='form-control select2' name='emp_class' required/>";
														echo "<option value='0'>Not Set</option>";
													while($roleRow = mysqli_fetch_array($roleQueIns,MYSQLI_ASSOC)){
														if($baseRole == $roleRow['classification']){
															echo "<option value='".$roleRow['id']."#".$roleRow['classification']."' selected>".$roleRow['classification']."</option>";
														}else{
															echo "<option value='".$roleRow['id']."#".$roleRow['classification']."'>".$roleRow['classification']."</option>";
														}
													}
													echo "</select>";
												?>
												<label>OLS ACCOUNT</label>
												<select class="form-control" name='olsAcc'>
													<option value=''>Not Set</option>
													<?php
														echo $active = $person -> active();

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
													$password = $person -> getPassword();
													if($password == md5("password")){
														echo "<h5 onmouseover='defaultPass()'>PASSWORD IS DEFAULT</h5>";
													}else{
														echo "<p class='text-center'>ACCOUNT HAS UPDATED PASSWORD</p>";
													$admin_id = $_SESSION['personnel'];
													if($admin_id!=='347')
														{
														echo '<button type="button" class="btn btn-block btn-sm btn-secondary" onclick="passwordResConf()">RESET <i class="fas fa-history ml-1"></i></button>';
													}}
												?>
											</div>
											<div class="col-sm-6" >
												<label class="mt-2">VALIDATION</label>
												<?php
													if($person -> getValidation() == "2"){
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
			</section>
			<footer class="main-footer mt-2">
			<div class="float-right d-none d-sm-inline">
				LDN-PORTAL
			</div>
		<strong>Copyright &copy; <?php echo date('Y');?> <a href="https://depedldn.com">DIVISION-ICT</a>.</strong> All rights reserved.
		</footer>
		</div>
		
		</div>
		
		<?php
			include('footer.php');
		?>
		<script>
		$(document).ready(function(){
			document.getElementById('personnelButton').className = "nav-link active";
		});
		$(function (){
			$(".table").DataTable({
				"responsive": true,
				"autoWidth": false,
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
		function defaultPass(){
			toastr.error("Password is password","Password is already default")
		}
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
		</script>
	</body>
</html>
<?php
	if(isset($_POST['logoutButton'])){
		unset($_SESSION['personnel']);
		echo '<script>window.open("index.php","_self")</script>';
	}

	if(isset($_POST['update1'])){
		$hris = $_GET['active'];
		$fname = $_POST['firstname'];
		$midname = $_POST['midname'];
		$lastname = $_POST['lastname'];
		$extname = $_POST['extname'];
		$bday = $_POST['bday'];
		$cstatus = $_POST['cstatus'];
		$blood = $_POST['bloodtype'];
		$gender = $_POST['gender'];
		$contact = $_POST['contact'];
		$query = "update tbl_employee set firstname = '$fname', middlename = '$midname',lastname = '$lastname',ext_name = '$extname',birth_date = '$bday',civil_status = '$cstatus',blood_type = '$blood',gender='$gender',contact_no = '$contact' where hris_code = '$hris'";
		if(mysqli_query($fconn2,$query)){
			echo '<script>
					Swal.fire({
						icon:"success",
						title:"UPDATE",
						html:"<p>Employee details has been successfully updated</p><p><button class=\"btn btn-secondary btn-block\" onclick=\"swal.close()\">Close</button></p>",
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
						title:"UPDATE",
						html:"<p>Update failed.</p><p><button class=\"btn btn-secondary btn-block\" onclick=\"swal.close()\">Close</button></p>",
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
	if(isset($_POST['update2'])){
		$hris = $_GET['active'];
		$emp_no = $_POST['emp_no'];
		$emp_stat = $_POST['emp_stat'];
		$itemNo = $_POST['itemNo'];
		$salary_grade = $_POST['salary_grade'];
		$salary_step = $_POST['salary_step'];
		$office = $_POST['office'];
		$appointment_date = $_POST['appointment_date'];
		$cont_service = $_POST['cont_service'];
		$position = $_POST['position'];

		$query= "update tbl_employee set employee_no = '$emp_no',ItemNo = '$itemNo',employment_status = '$emp_stat',salary_grade = '$salary_grade',salary_step='$salary_step',position = '$position',department_id='$office',appointment_date='$appointment_date',startdatecontinuesservice='$cont_service' where hris_code = '$hris'";
		if(mysqli_query($fconn2,$query)){
			echo '<script>
				Swal.fire({
					icon:"success",
					title:"UPDATE",
					html:"<p>Employee details has been successfully updated</p><p><button class=\"btn btn-secondary btn-block\" onclick=\"swal.close()\">Close</button></p>",
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
					title:"UPDATE",
					html:"<p>Update failed.</p><p><button class=\"btn btn-secondary btn-block\" onclick=\"swal.close()\">Close</button></p>",
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
	if(isset($_POST['update3'])){
		$hris = $_GET['active'];
		$tin = $_POST['tin'];
		$sss = $_POST['sss'];
		$gsis = $_POST['gsis'];
		$philhealth = $_POST['philhealth'];

		$query = "update tbl_employee set tin = '$tin',sss='$sss',gsis='$gsis',philhealth='$philhealth' where hris_code = '$hris'";
		if(mysqli_query($fconn2,$query)){
			echo '<script>
				Swal.fire({
					icon:"success",
					title:"UPDATE",
					html:"<p>Employee details has been successfully updated</p><p><button class=\"btn btn-secondary btn-block\" onclick=\"swal.close()\">Close</button></p>",
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
					title:"UPDATE",
					html:"<p>Update failed.</p><p><button class=\"btn btn-secondary btn-block\" onclick=\"swal.close()\">Close</button></p>",
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
	if(isset($_POST['updateols'])){
	 	$hris_code = $_GET['active'];
	 	$username = $_POST['username'];
	 	$role = explode("#",$_POST['emp_class']);
		$roleNo = $role[0];
		$roleClass = $role[1];
		$newUser = unameChk($username);
		$active = $_POST['olsAcc'];

		if($active == '0'){
			$jobStatus = 'Inactive';
		}else{
			$jobStatus = 'Active';
		}

		$update = "update tbl_employee set username = '$newUser', employee_classification = '$roleNo',active = '$active',jobSTATUS = '$jobStatus' where hris_code = '$hris_code'";
		
		if(mysqli_query($fconn2,$update)){
			echo "<script>Swal.fire({
				icon:'success',
				title:'OLS Credentials Updated.',
				html:'<p>Username is now \'".$newUser."\'</p>'+
				'<p>Employee Classification is now \'".$roleClass."\'</p>'+
				'<p>Online Leave Account is set to \'".$jobStatus."\'</p>'+
				'<small class=\'mb-2\'>note: To prevent username duplication, The system may add digits to the created/edited username.</small>'+
				'<p><button type=\'button\' class=\'btn btn-secondary btn-block btn-sm mt-2\' onclick=\'swal.close()\'>CLOSE</button></p>',
				allowOutsideClick:false,
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
		$hris = $_GET['active'];
		//$username = $_POST['username'];
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
	function unameChk($uname){
        include("fdatabase.php");
		$hris_code = $_GET['active'];
     	$query = "select username from tbl_employee where username = '$uname' and hris_code != '$hris_code'";
        $queryIns = mysqli_query($fconn2,$query);
        $queryRow = mysqli_fetch_all($queryIns,MYSQLI_BOTH);
        
        if(count($queryRow) > 0){
            $numbers = extract_numbers($uname);
            if(strlen($numbers) > 0){
                $decimal = $numbers+1;
                if(strlen($decimal) < 3){
                    while(strlen($decimal) < 3){
                        $decimal = "0".$decimal;
                    }
                }
                $username = explode("@",$uname);
                $newuser = str_replace($numbers,"",$username[0]).$decimal."@deped.gov.ph";
                return unameChk($newuser);
            }else{
                $decimal = "001";
                $username = explode("@",$uname);
                $newuser = $username[0].$decimal."@deped.gov.ph";
                return unameChk($newuser);
            }
        }else{
            return $uname;
        }
    }
	function extract_numbers($string){
        preg_match_all('/([\d]+)/', $string, $match);
        return implode($match[0]);        
    }

?>