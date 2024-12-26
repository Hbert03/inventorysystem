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
		<script type="text/javascript" src="plugins/xlsx@0.15.1/xlsx.full.min.js"></script>
	</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container-fluid">
            <a href="homepage_sch.php" class="navbar-brand">
                <img src="dist/img/depedldn.png" alt="HRIS LOGO" class="brand-image img-circle elevation-3" style="opacity: .8">
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
		<div class="content-header bg-teal mb-2 pb-1">
		  <div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-bold">ELEMENTARY ENROLLMENT UPLOAD</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="homepage_planning.php">Home</a></li>
						<li class="breadcrumb-item active">Enrollment Upload</li>
					</ol>
				</div>
			</div>
		  </div>
		</div>
        <section class="content">
			<div class="row">
				<div class="col-sm-3">
					<div class="container border border-danger" id="uploadingContainer">
						<h4 class="my-1 text-center text-bold bg-red">UPLOADING</h4>
						<label>SCHOOL YEAR</label>
						<div class="row mb-1">
							<div class="col">
								<input type="number" min="2020" max="2099" id="schyearA" placeholder="School Year" class="form-control" onchange="nextYear(this.value)" required/>
							</div>
							<div class="col-sm-1">
								<span class="text-bold text-lg">-</span>
							</div>
							<div class="col">
								<input type="number" min="2020" max="2100" id="schyearB" class="form-control" readonly/>
							</div>
						</div>
						<label>MONTH</label>
						<select type="month" class="form-control mb-2" id="monthEnroll">
							<option value="">Select Month</option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
						<label>FILE</label>
						<input type="file" class="form-control-file mb-2" onchange="viewTable()" id="excel_file">
					</div>
				</div>
				<div class="col-sm-4">
					<div class="container border border-primary text-justify" id="enrollmentContainer" style="overflow:auto;">
						<h4 class="my-1 text-center bg-primary text-bold mb-2">UPLOADED ENROLLMENT DATA</h4>
						<ul id="listedEnrollment" class="text-bold text-justify">
							
						</ul>
					</div>
				</div>
				<div class="col-sm-12 mt-2">
					<div class="container-fluid" id="table-card" id="elemTable" style="display:none;">
						<table class="table table-bordered table-hover" id="elemTable">
							<div class="row">
								<div class="col-sm-6">
								</div>
								<div class="col-sm-6">
									<div class="table-danger text-dark text-center my-1" style="border-radius:50px;"><strong>NOT RECORDED IN DATABASE</div>
								</div>
							</div>
							<thead>
								<tr>
									<th rowspan="2">SCHOOL ID</th>
									<th colspan="2">KINDER</th>
									<th colspan="2">GRADE 1</th>
									<th colspan="2">GRADE 2</th>
									<th colspan="2">GRADE 3</th>
									<th colspan="2">GRADE 4</th>
									<th colspan="2">GRADE 5</th>
									<th colspan="2">GRADE 6</th>
									<th colspan="2">NON-GRADED ES</th>
									<th colspan="2">TOTAL</th>
								</tr>
								<tr>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>MALE</th>
									<th>FEMALE</th>
									<th>TMALE</th>
									<th>TFEMALE</th>
								</tr>
							</thead>
						</table>
						<div class="alert alert-warning my-2" role="alert" id="schoolwarning" style="display:none;">
							<h4 class="alert-heading">Warning !</h4>
							<hr>
							<p>Some schools are not recorded in the database.</p>
						</div>
						<button class="btn btn-block btn-primary btn-sm my-2" id="validateButton" onclick="showUpload()" style="display:none;"><i class="fas fa-check-double mr-3" ></i> VALIDATE, ALL DATA ARE CORRECT</button>
						
						<button class="btn btn-success btn-block btn-sm mb-2" style="display:none;" id="uploadButton" onclick="uploadEnrollment(this.value)">UPLOAD</button>
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
		//global variables
		$(document).ready(function(){
			$.ajax({
				url:"uploadEnrollment.php",
				type:"post",
				data:{
					uploadedEnrollment:true,type:"1"
				},
				success:function(val){
					var enrollmentdata = JSON.parse(val);
					var y = "";
					for(var x = 0; x <= enrollmentdata.length-1;x++){
						var array = enrollmentdata[x];
						y = y + "<li>"+getMonth(array[0])+" "+array[1]+"</li>";
					}
					var height = document.getElementById("uploadingContainer").offsetHeight;
					document.getElementById("listedEnrollment").innerHTML = y;
					document.getElementById("enrollmentContainer").style.height = height+"px";
					document.getElementById("enrollmentContainer").style.position = "relative";
				}
			})
		})
		var contschoolid = [];
		var k=[];
		var g1=[];
		var g2=[];
		var g3=[];
		var g4=[];
		var g5=[];
		var g6=[];
		var nonG=[];
		var errschIDcnt = 0;
		
		function loader(){
			Swal.fire({
				html: '<p><i class="fas fa-spinner fa-pulse fa-6x"></i></p><p>Loading please wait..</p>',
				showConfirmButton: false,
				allowOutsideClick: false,
			});
		}
		function showUpload(){
			var syA= document.getElementById('schyearA').value;
			var syB= document.getElementById('schyearB').value;
			var month= document.getElementById('monthEnroll').value;
			if(syA == "" || syB == "" || month == ""){
				swal.fire({
					icon:"warning",
					showConfirmButton:false,
					allowOutsideClick:false,
					html:"<p class='mb-2'>Please indicate school year and month before uploading.</p>"+
						"<p><button class='btn btn-block btn-xs btn-secondary mt-2' onclick='swal.close()'>CLOSE</button</p>",
					
				})
			}else{
				var schyr = syA+"-"+syB;
				document.getElementById('uploadButton').value = schyr;
				document.getElementById('uploadButton').style.display = "block";
				document.getElementById('validateButton').style.display = "none";
				
			}
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
		function nextYear(val){
			document.getElementById('schyearB').value = parseInt(val)+1;
		}
		function viewTable(){
			errschIDcnt = 0;
			var x = document.getElementById('excel_file');
			if(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(x.files[0].type)){
				var reader = new FileReader();
				reader.readAsArrayBuffer(x.files[0]); 
				reader.onloadstart = function(event){
					loader();
				}
				reader.onload = function(event){
					var data = new Uint8Array(reader.result);
					var work_book = XLSX.read(data, {type:'array'});
					var sheet_name = work_book.SheetNames;
					var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});
					
					var startRow = '';
					var schidCol = '';
					var kinderCol = '';
					var oneCol = '';
					var twoCol = '';
					var threeCol = '';
					var fourCol = '';
					var fiveCol = '';
					var sixCol = '';
					var ngCol = '';
					
					//values
					var school_id = [];
					var kinderM = [];
					var kinderF = [];
					var oneM = [];
					var oneF = [];
					var twoM = [];
					var twoF = [];
					var threeM = [];
					var threeF = [];
					var fourM = [];
					var fourF = [];
					var fiveM = [];
					var fiveF = [];
					var sixM = [];
					var sixF = [];
					var ngM = [];
					var ngF = [];
					
					for(var row = 1; row <= sheet_data.length-1;row++){
						for(var col = 0; col <= sheet_data[row].length;col++){
							var headerName = sheet_data[row][col];
							switch(headerName){
								case "SCH. ID":
									schidCol = col;
									startRow = row+1;
									break;
								case "Kindergarten":
									kinderCol = col;
									break;
								case "Grade 1":
									oneCol = col;
									break;
								case "Grade 2":
									twoCol = col;
									break;
								case "Grade 3":
									threeCol = col;
									break;
								case "Grade 4":
									fourCol = col;
									break;
								case "Grade 5":
									fiveCol = col;
									break;
								case "Grade 6":
									sixCol = col;
									break;
								case "Non-Graded ES":
									ngCol = col;
									break;
							}
							
							if(parseInt(schidCol) == col && row > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									school_id.push(sheet_data[row][col])
								}
							}
							//KINDER
							if(parseInt(kinderCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									kinderM.push(sheet_data[row-1][col])
									kinderF.push(sheet_data[row-1][col+1])
								}
							}
							//GRADE 1
							if(parseInt(oneCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									oneM.push(sheet_data[row-1][col])
									oneF.push(sheet_data[row-1][col+1])
								}
							}
							//GRADE 2
							if(parseInt(twoCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									twoM.push(sheet_data[row-1][col])
									twoF.push(sheet_data[row-1][col+1])
								}
							}
							//GRADE 3
							if(parseInt(threeCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									threeM.push(sheet_data[row-1][col])
									threeF.push(sheet_data[row-1][col+1])
								}
							}
							//GRADE 4
							if(parseInt(fourCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									fourM.push(sheet_data[row-1][col])
									fourF.push(sheet_data[row-1][col+1])
								}
							}
							//GRADE 5
							if(parseInt(fiveCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									fiveM.push(sheet_data[row-1][col])
									fiveF.push(sheet_data[row-1][col+1])
								}
							}
							//GRADE 6
							if(parseInt(sixCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									sixM.push(sheet_data[row-1][col])
									sixF.push(sheet_data[row-1][col+1])
								}
							}
							//NON GRADED
							if(parseInt(ngCol) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									ngM.push(sheet_data[row-1][col])
									ngF.push(sheet_data[row-1][col+1])
								}
							}
							
						} 
					}
					if(startRow,kinderCol,oneCol,twoCol,threeCol,fourCol,fiveCol,sixCol,ngCol == ""){
						swal.fire({
							icon:"error",
							showConfirmButton:false,
							allowOutsideClick:false,
							html:"<p class='mb-2'>Wrong file!</p>"+
								"<hr>"+
								"<p><button class='btn btn-block btn-xs btn-secondary' onclick='swal.close()'>CLOSE</button</p>",
						}).then(()=>{window.open(location.href.replace('#',''),'_self')});
					}else{
						contschoolid.push(school_id);
						k.push(kinderM,kinderF);
						g1.push(oneM,oneF);
						g2.push(twoM,twoF);
						g3.push(threeM,threeF);
						g4.push(fourM,fourF);
						g5.push(fiveM,fiveF);
						g6.push(sixM,sixF);
						nonG.push(ngM,ngF);
						
						$.ajax({
							url:"uploadEnrollment.php",
							type:"post",
							data:{chckschID:school_id},
							success:rowAdder,
						})
						document.getElementById('table-card').style.display = "block";	
					}
				}
			}else{
				swal.fire({
					icon:"error",
					showConfirmButton:false,
					allowOutsideClick:false,
					html:"<p>Only .xlsx or .xls file format are allowed</p>"+
						"<p><button class='btn btn-block btn-sm btn-secondary' onclick='swal.close()'>CLOSE</button</p>",
					
				})
			}
			
		}
		function rowAdder(data){
			var data = JSON.parse(data)
			var table = $('#elemTable').DataTable({"responsive": true,"autoWidth": false,"ordering": false,});
			for(var iteration = 0;iteration <= data.length-1;iteration++){
				var trow = table.row.add([contschoolid[0][iteration],k[0][iteration],k[1][iteration],g1[0][iteration],g1[1][iteration],g2[0][iteration],g2[1][iteration],g3[0][iteration],g3[1][iteration],g4[0][iteration],g4[1][iteration],g5[0][iteration],g5[1][iteration],g6[0][iteration],g6[1][iteration],nonG[0][iteration],nonG[1][iteration]]).draw().node();
				if(data[iteration] == "non-existent"){
					errschIDcnt=errschIDcnt+1;
					$(trow).addClass("table-danger");
				}
			}
			swal.close();
			if(errschIDcnt > '0'){
				document.getElementById('schoolwarning').style.display="block";
			}else{
				document.getElementById('validateButton').style.display="block";
			}
		}
		function uploadEnrollment(val){
			loader();
			var month = document.getElementById('monthEnroll').value;
			var monthWord = getMonth(month);
			var schyear = document.getElementById('schyearA').value+"-"+document.getElementById('schyearB').value;
			var schoolEnrollment = [];
			for(var x=0;x <= contschoolid[0].length-1;x++){
				var temparray = [contschoolid[0][x],k[0][x],k[1][x],g1[0][x],g1[1][x],g2[0][x],g2[1][x],g3[0][x],g3[1][x],g4[0][x],g4[1][x],g5[0][x],g5[1][x],g6[0][x],g6[1][x],nonG[0][x],nonG[1][x]];
				schoolEnrollment.push(temparray);
			}
			//alert(schoolEnrollment[0]);
			$.ajax({
				url:"uploadEnrollment.php",
				type:"post",
				data:{elementaryData:schoolEnrollment,schoolyear:val,month:month},
				success:function(returnedData){
					if(returnedData == 0){
						swal.fire({
							icon:"success",
							showConfirmButton:false,
							allowOutsideClick:false,
							html:"<p>UPLOAD SUCCESSFUL</p><p><button class='btn btn-xs btn-block btn-success' onclick='swal.close()'>CLOSE</button></p>"
						}).then(()=>{window.open(location.href.replace('#',''),'_self')});
					}else if(returnedData == '2'){
						swal.fire({
							icon:"error",
							showConfirmButton:false,
							allowOutsideClick:false,
							html:"<p>Enrollment data for the month of "+monthWord+", and school year \""+schyear+"\" already exist.</p><button class='btn btn-xs btn-block btn-danger' onclick='swal.close()'>CLOSE</button></p>",
						}).then(()=>{window.open(location.href.replace('#',''),'_self')});
					}else{
						swal.fire({
							icon:"error",
							showConfirmButton:false,
							allowOutsideClick:false,
							html:"<p>Something went wrong on enrollment upload.</p><button class='btn btn-xs btn-block btn-danger mt-2' onclick='swal.close()'>CLOSE</button>"
						}).then(()=>{window.open(location.href.replace('#',''),'_self')});
					}
				}		
			});
		}
		function getMonth(val){
			switch(val){
				case "1":
					return "JANUARY";
					break;
				case "2":
					return "FEBRUARY";
					break;
				case "3":
					return "MARCH";
					break;
				case "4":
					return "APRIL";
					break;
				case "5":
					return "MAY";
					break;
				case "6":
					return "JUNE";
					break;
				case "7":
					return "JULY";
					break;
				case "8":
					return "AUGUST";
					break;
				case "9":
					return "SEPTEMBER";
					break;
				case "10":
					return "OCTOBER";
					break;
				case "11":
					return "NOVEMBER";
					break;
				case "12":
					return "DECEMBER";
					break;
					
			}
		}
	</script>
</body>
</html>
<?php
    if(isset($_POST['logoutButton'])){
		unset($_SESSION['planning']);
		echo '<script>window.open("index.php","_self")</script>';
	}
	
?>
