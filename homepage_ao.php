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
							<h1 class="m-0 text-bold" id="sectionHeader">ADMINISTRATIVE OFFICER II</h1>
						</div>
					</div>
				</div>
			
		</div>
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
					<div class="row d-flex">
                        <div class="col-lg-12 col-sm-2">
                            <div class="card" id="personnelTable" style="display:block;">
                                <div class="card-header">
                                    <div><div class='text-center text-lg text-bold'>PERSONNEL LIST</div></div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover maintable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>FULL NAME</th>
                                                <th>POSITION</th>
                                                <th>EMPLOYEE CLASSIFICATION</th>
                                                <th>USERNAME</th>
                                                <th>PASSWORD</th>
                                                <!-- <th>VALIDATION</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $personnel = "select tbl_district_office_user.hris,tbl_district_office_user.* from tbl_district_office_user join tbl_employee on tbl_employee.hris_code = tbl_district_office_user.hris where tbl_district_office_user.active='1' AND tbl_employee.position='Administrative Officer II'";
                                                $personnelIns = mysqli_query($fconn2,$personnel);
                                                while($personnelRow = mysqli_fetch_array($personnelIns,MYSQLI_ASSOC)){
                                                    $officePersonnel = new Person;
                                                    $officePersonnel -> setter($personnelRow['hris']);
                                                    echo '<tr>
                                                            <td>'.$officePersonnel->getName('full').'</td>
                                                            <td>'.$officePersonnel->getPosition().'</td>
                                                            <td>'.$officePersonnel->getRole().'</td>';
                                                            
                                                            echo '<td>'.$personnelRow['useraccount'].'</td>';
                                                            if(md5('password') == $personnelRow['password']){
                                                                echo "<td><p class='text-center'>DEFAULT</p></td>";
                                                            }else{
                                                                echo '<td class=""><button class="btn btn-block btn-primary btn-sm" onclick="passwordResConf(\''.$officePersonnel->getName('full').'#jda#'.$personnelRow['id'].'\')">RESET</button></td>';
															}
															$validity = $officePersonnel->getValidation();
															// echo '<td style=""><button class="btn btn-primary btn-block btn-sm"><span class="d-lg-block d-sm-none">EDIT</span><span class="d-lg-none d-sm-block"><i class="fas fa-edit d-lg-none d-sm-block"></i></span></button></td>';
															/*if($validity == '0'){
																echo '<td class="text-center" onmouseover="noAccess(\''.ucwords($officePersonnel->getName('full')).'\')">INACTIVE</td>';
															}else if($validity == '1'){
																echo '<td class=""><button class="btn btn-block btn-primary btn-sm" onclick="validate(\''.$officePersonnel->getName('full').'#jda#'.$personnelRow['hris_code'].'\')">VALIDATE</button></td>';
															}else{
																echo '<td class="text-center" onmouseover="validated(\''.ucwords($officePersonnel->getName('full')).'\')">VALIDATED</td>';
															}*/
															
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
		$id = $_POST['passwordRes'];
		$defaultPass = md5("password");
		$updQuery = "update tbl_district_office_user set password = '$defaultPass' where id = '$id'";
		
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
