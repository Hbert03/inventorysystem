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
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark" id="sectionHeader">ADD EMPLOYEE</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
							  <li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
							  <li class="breadcrumb-item active">Add Employee</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
            <button class="btn btn-danger btn-sm ml-2 mb-2" onclick="back()"><i class="fas fa-chevron-circle-left mr-2"></i>BACK</button>
			<section class="content">
                <form method="POST">
                <div class="card">
                    <div class="card-header text-lg text-bold">EMPLOYEE DETAILS</div>
                    <div class="card-body">
                        <div class="row bg-dark pb-2" style="border-radius:10px;">
                            <div class="col-sm-4">
                                <label>EMPLOYEE NUMBER</label>
                                <input class="form-control" placeholder="EMPLOYEE NUMBER" name="empNo" id="empNo" required/>
                            </div>
                            <div class="col-sm-4">
                                <label>ITEM NUMBER</label>
                                <input class="form-control" placeholder="ITEM NUMBER" name="itemNo" id="itemNo" required/>
                            </div>
							<div class="col-sm-4">
                                <label>EMPLOYMENT STATUS</label>
								<select name="empStat" id="empStat" class="form-control select2" required/>
									<option value="">SELECT EMPLOYMENT STATUS</option>
									<option value="REGULAR PERMANENT">REGULAR PERMANENT</option>
									<option value="PROVISIONAL">PROVISIONAL</option>
								</select>
                            </div>
                            <div class="col-sm-4">
                                <label>POSITION</label>
								 <select class="form-control select2" placeholder="POSITION" name="position" id="position" required/>
								<?php
									$select = "select * from tbl_position";
									$selIns = mysqli_query($fconn2,$select);
									
									while($selRow = mysqli_fetch_array($selIns,MYSQLI_ASSOC)){
										echo '<option value="'.$selRow['position_description'].'">'.$selRow['position_description'].'</option>';
									}
								?>
                               
								</select>
                            </div> 
							<div class="col-sm-4">
                                <label>EMPLOYEE CLASIFICATION</label>
								 <select class="form-control select2" placeholder="classification" name="classification" id="classification" required/>
								<?php
									$selectClassification = "select * from tbl_emp_classification";
									$classificationIns = mysqli_query($fconn2,$selectClassification);
									
									while($classificationRow = mysqli_fetch_array($classificationIns,MYSQLI_ASSOC)){
										echo '<option value="'.$classificationRow['id'].'">'.$classificationRow['classification'].'</option>';
									}
								?>
                               
								</select>
                            </div>
							
							
                            <div class="col-sm">
                                <label>ASSIGNMENT PLANTILLA</label>
                                <input class="form-control" placeholder="PLANTILLA" name="plantilla" id="plantilla" required/>
                            </div> 
                            <div class="col-sm-4">
                                <label>SALARY GRADE</label>
                                <input class="form-control" placeholder="SALARY GRADE" name="salaryGrade" id="salaryGrade" required/>
                            </div>
                            <div class="col-sm-4">
                                <label>SALARY STEP</label>
                                <input class="form-control" placeholder="SALARY STEP" name="salaryStep" id="salaryStep" required/>
                            </div>
                            <div class="col-sm-4">
                                <label>APPOINTMENT DATE</label>
                                <input type="date" class="form-control" placeholder="APPOINTMENT DATE" name="appointmentDate" id="appointmentDate" required/>  
                            </div>
                            <div class="col-sm-4">
                                <label>START DATE OF CONTINUED SERVICE</label>
                                <input type="date" class="form-control" placeholder="APPOINTMENT DATE" name="startDate" id="startDate" required/>  
                            </div>
                            <div class="col-sm-4">
                                <label>DEPARTMENT ID/SCHOOL ID</label>
                                <input type="text" class="form-control" placeholder="DEPARTMENT ID" value="<?php echo $_GET['active']; ?>" name="deptId" id="deptId" readonly/>  
                            </div>
                        </div>
                        <div class="row bg-secondary pb-2" style="border-radius:10px;">
                            <div class="col-sm-3">
                                <label>FIRSTNAME</label>
                                <input class="form-control" placeholder="FIRSTNAME" name="fname" id="fname" required/>
                            </div>
                            <div class="col-sm-3">
                                <label>MIDDLE NAME</label>
                                <input class="form-control" placeholder="MIDDLENAME" name="midname" id="midname"required/>  
                            </div>
                            <div class="col-sm-3">
                                <label>LASTNAME</label>
                                <input class="form-control" placeholder="LASTNAME" name="lname" id="lname" required/>  
                            </div>
                            <div class="col-sm" >
                                <label>EXTENSION NAME</label>
                                <select class="form-control" name="extname" id="extname">
                                    <option value="">NONE</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="Senior">Sr.</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <label>GENDER</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">NONE</option>
                                    <option value="M">MALE</option>
                                    <option value="F">FEMALE</option>
                                </select>
                            </div>
                            <div class="w-100 mb-1"></div>
                            <div class="col-sm-3">
                                <label>CIVIL STATUS</label>
                                <select class="form-control" name="cstatus" id="cstatus">
                                    <option value="">NONE</option>
                                    <option value="MARRIED">MARRIED</option>
                                    <option value="SINGLE">SINGLE</option>
                                    <option value="WIDOWED">WIDOWED</option>
                                    <option value="SEPARATED">SEPARATED</option>
                                    <option value="DIVORCED">DIVORCED</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>CONTACT NUMBER</label>
                                <input class="form-control" placeholder="CONTACT" name="contact" id="contact">  
                            </div>
                            <div class="col-sm-3">
                                <label>BLOOD TYPE</label>
                                <input class="form-control" placeholder="BLOOD TYPE" name="bloodtype" id="bloodtype">  
                            </div>
                            <div class="col-sm-3">
                                <label>EMAIL</label>
                                <input class="form-control" placeholder="EMAIL" name="empEmail" id="empEmail">  
                            </div>

                        </div>
                        <div class="row bg-dark pb-2" style="border-radius:10px;">
                            <div class="col-sm-12 text-center">
                                <label class="mt-1">ADDRESS</label>
                            </div>
                            <div class="col">
                                <input class="form-control" placeholder="BARANGAY" name="addressB" id="addressB">
                            </div>
                            <div class="col">
                                <input class="form-control" placeholder="MUNICIPALITY" name="addressM" id="addressM">
                            </div>
                             <div class="col"> 
                                   <input class="form-control" placeholder="PROVINCE" name="addressP" id="addressP">
                            </div>
                             <div class="col-sm-1">
                                   <input class="form-control" placeholder="ZIP CODE" name="zip" id="zip">
                            </div>
                        </div>
                        <div class="row bg-secondary pb-2" style="border-radius:10px;">
                            <div class="col-sm-5">
                                <label>BIRTHDAY</label>
                                <input type="date" class="form-control" placeholder="birthday" name="birthday" id="birthday">
                            </div>
                            <div class="col-sm-7 text-center">
                                <label class="text-center">BIRTH PLACE</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                         <input type="text" class="form-control" placeholder="MUNICIPALITY" name="birthM" id="birthM">
                                    </div>
                                    <div class="col-sm-6">
                                         <input type="text" class="form-control" placeholder="PROVINCE" name="birthP" id="birthP">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row bg-dark pb-2" style="border-radius:10px;">
                            <div class="col-sm-3">
                                <label>TIN</label>
                                <input class="form-control" placeholder="TIN" name="tin" id="tin">
                            </div>
                            <div class="col-sm-3">
                                <label>SSS</label>
                                <input class="form-control" placeholder="SSS" name="sss" id="sss">
                            </div>
                            <div class="col-sm-3">
                                <label>GSIS</label>
                                <input class="form-control" placeholder="GSIS" name="gsis" id="gsis">
                            </div>
                            <div class="col-sm-3">
                                <label>PHILHEALTH</label>
                                <input class="form-control" placeholder="PHILHEALTH" name="phealth" id="phealth">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm mt-2 float-right" name="createEmployee" >CREATE</button>
                    </div>
                </div>
            </form>
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
			document.getElementById('addEmployeeButton').className = "nav-link active";
		});
		$(function (){
			$(".table").DataTable({
				"responsive": true,
				"autoWidth": false,
			});
		});	
        function back(){
            var url = location.href;
            var sch = url.split("?active=");
                sch = sch[1];

            window.open('schoolDetail.php?active='+sch,'_self');
        }
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
		unset($_SESSION['user']);
		echo '<script>window.open("index.php","_self")</script>';
	}
    if(isset($_POST['createEmployee'])){
        $hris_code = getHris();
        $empNo =  $_POST['empNo'];
        $itemNo =  $_POST['itemNo'];
        $position =  $_POST['position'];
        $salaryGrade =  $_POST['salaryGrade'];
        $salaryStep =  $_POST['salaryStep'];
        $employeeStat =  $_POST['empStat'];
        $classification =  $_POST['classification'];
        $appointmentDate =  $_POST['appointmentDate'];
        $plantilla =  $_POST['plantilla'];
        $startDate =  $_POST['startDate'];
        $deptId =  $_POST['deptId'];
        $deptId = getDepartment($deptId);
        $fname =  $_POST['fname'];
        $midname =  $_POST['midname'];
        $lname =  $_POST['lname'];
        $extname =  $_POST['extname'];
        $gender =  $_POST['gender'];
        $cstatus =  $_POST['cstatus'];
        $contact =  $_POST['contact'];
        $bloodtype =  $_POST['bloodtype'];
        $empEmail =  $_POST['empEmail'];
        $addressB =  $_POST['addressB'];
        $addressM =  $_POST['addressM'];
        $addressP =  $_POST['addressP'];
        $zip =  $_POST['zip'];
        $bday =  $_POST['birthday'];
        $birthM =  $_POST['birthM'];
        $birthP =  $_POST['birthP'];
        $tin =  $_POST['tin'];
        $sss =  $_POST['sss'];
        $gsis =  $_POST['gsis'];
        $phealth =  $_POST['phealth'];

       
        $username = strtolower(str_replace(" ","",$_POST['lname'])).".".strtolower(str_replace(" ","",$_POST['fname']))."@deped.gov.ph";
        $username = unameChk($username);
        $password = md5("password");
        $query = "insert into tbl_employee(hris_code,username,password,firstname,middlename,lastname,ext_name,addressB,addressM,addressP,birth_date,birth_placeM,birth_placeP,gender,civil_status,tin,sss,gsis,philhealth,employee_no,ItemNo,employment_status,contact_no,position,employee_classification,assignment_plantilla,appointment_date,active,JobSTATUS,zip,salary_grade,salary_step,email,startdatecontinuesservice,blood_type,department_id,update_password,validation)values
                ('$hris_code','$username','$password','$fname','$midname','$lname','$extname','$addressB','$addressM','$addressP','$bday','$birthM','$birthP','$gender','$cstatus','$tin','$sss','$gsis','$phealth','$empNo','$itemNo','$employeeStat','$contact','$position','$classification','$plantilla','$appointmentDate','1','Active','$zip','$salaryGrade','$salaryStep','$empEmail',' $startDate','$bloodtype','$deptId','0','0')";
        if(mysqli_query($fconn2,$query)){
            echo "<script>Swal.fire({
                icon:'success',
                title:'Employee Created',
                html:'<p>You have successfully created employee </p><button class=\'btn btn-secondary btn-block\' onclick=\'swal.close()\'>CLOSE</button>',
                showConfirmButton:false,
                allowOutsideClick:false,
            }).then(()=>{window.open(location.href,'_self')})</script>";
        }else{
            echo "<script>Swal.fire({
                icon:'error',
                title:'Something went wrong',
                html:'<p>Something went wrong while creating employee, If error persist contact your ICT</p><button class=\'btn btn-secondary btn-block\' onclick=\'swal.close()\'>CLOSE</button>',
                showConfirmButton:false,
                allowOutsideClick:true,
            }).then(()=>{window.open(location.href,'_self')})</script>";
        }
    }
    function extract_numbers($string){
        preg_match_all('/([\d]+)/', $string, $match);
        return implode($match[0]);        
    }
    function getDepartment($depID){
        include("fdatabase.php");
        
        $query="select * from tbl_office where office_id= '$depID'";
        $queryIns = mysqli_query($fconn2,$query);
        $queryRow = mysqli_fetch_all($queryIns,MYSQLI_BOTH);

        if(count($queryRow) != 0){
            return $queryRow[0]['id'];
        }else{
            echo "<script>Swal.fire({
                    icon:'error',
                    title:'Something went wrong',
                    html:'<p>Something went wrong with the Department ID, If error persist contact your ICT</p><button class=\'btn btn-secondary btn-block\' onclick=\'swal.close()\'>CLOSE</button>',
                    showConfirmButton:false,
                    allowOutsideClick:false,
            }).then(()=>{window.open(location.href,'_self')})</script>";
        }
    }
    function getHris(){
        include("fdatabase.php");

        $query = "select max(hris_code) as max from tbl_employee";
        $queryIns = mysqli_query($fconn2,$query);
        $queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC);

        $hris = $queryRow['max']+1;
        return $hris;
    }
    function unameChk($uname){
        include("fdatabase.php");
        $query = "select username from tbl_employee where username = '$uname'";
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
?>