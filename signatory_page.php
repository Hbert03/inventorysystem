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
							<h1 class="m-0 text-bold" id="sectionHeader">OLS SIGNATORY</h1>
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container-fluid" id="dashboard">
					<div class="card">
						<div class="card-header">
							<h3 class="text-bold">OLS SIGNATORY</h3>
						</div>
						<div class="card-body">
							<table class="table table-bordered table-hover" id="signatory_id">
								<thead>
									<tr>
										<th>SIGNATORY NAME</th>
										<th>POSITION</th>
										<th>DATE FROM</th>
										<th>DATE TO</th>
										<th>ROLE</th>
										<th>REMARKS</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-header">
								<p class="lead">ADD SIGNATORY</p>
							</div>
							<div class="card-body">
								<form method="post">
								<label>Select Signatory</label>
								<select id="personnel" name="personnel" class="form-control select2 mb-2" required/>
										<option value="">SELECT PERSONNEL</option>
										<?php
											$personnelQuery = "select * from tbl_employee where lastname != '' order by lastname ASC";
											$personnelIns = mysqli_query($fconn2,$personnelQuery);
											while($personnelRow = mysqli_fetch_array($personnelIns,MYSQLI_ASSOC)){
												echo '<option value="'.$personnelRow['hris_code'].'">'.$personnelRow['firstname']." ".$personnelRow['middlename']." ".$personnelRow['lastname']." ".$personnelRow['ext_name'].'</option>';
											}
										?>
								</select>
								<label>Position</label>
								<input class="form-control mb-2" name="position" id="position" required/>
								<label>Role</label>
								<input class="form-control mb-2" name="role" id="role" required/>
								<label>Remarks</label>
								<input class="form-control mb-2" name="Remarks" id="Remarks" required/>
								<label>Date from</label>
								<input type="date" class="form-control mb-2" name="date_from" id="date_from" required/>
								<label>Date to</label>
								<input type="date" class="form-control mb-2" name="date_to" id="date_to"/>
								<button class="btn btn-success btn-block" name="addSignatory">ADD SIGNATORY</button>
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
			document.getElementById('signatoryButton').className = "nav-link active";
			$.ajax({
				url:"ajaxqueries.php",
				type:"post",
				data:{ols_signatories:true},
				success:function(returnedData){
					var signatoryArray = JSON.parse(returnedData);
					var table = $('#signatory_id').DataTable();
					//signatoryArray[[name],[hris],[pos],.....]
					//nameArray[0]
					//hrisArray[1]
					//positionArray[2]
					//dateFrom[3]
					//dateTo[4]
					//dateInactive[5]
					//remarks[6]
					signatoryArray[0].forEach(function(ele,index){
						 table.row.add([ele,signatoryArray[2][index],signatoryArray[3][index],signatoryArray[4][index],signatoryArray[5][index],signatoryArray[6][index]]).draw();
					})
				}
			})
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
	if(isset($_POST['addSignatory'])){
		$hris = $_POST['personnel'];
		$signatory = new Person();
		$signatory->setter($hris);
		$name = $signatory->getName("formatted");
		$signatory = $signatory->getSignature();
		$position = $_POST['position'];
		$dateTo = $_POST['date_to'];
		$dateFrom = $_POST['date_from'];
		$role = $_POST['role'];
		$remarks = $_POST['Remarks'];
		
		$query="insert into tbl_leave_signatory (hris,name,position,signature,date_from,date_to,remarks,role)values('$hris','$name','$position','$signatory','$dateFrom','$dateTo','$remarks','$role ')";
		
		if(mysqli_query($fconn2,$query)){
			echo "<script>Swal.fire({
				icon:\"success\",
				title:\"Signatory Added\",
				text:\"You have successfully added a signatory\",
				allowOutsideClick:false,
				showConfirmButton:false,
				showCloseButton:true,
				
			}).then(()=>{var x = location.href;
					x = x.split('#');
				window.open(x[0],'_self')})</script>";
		}else{
			
			echo "<script>Swal.fire({
				icon:\"error\",
				title:\"Server Error\",
				text:\"Something went wrong while adding signatory.\",
				allowOutsideClick:false,
				showConfirmButton:false,
				showCloseButton:true,
				
			}).then(()=>{var x = location.href;
					x = x.split('#');
				window.open(x[0],'_self')})</script>";
		}
	}
?>
