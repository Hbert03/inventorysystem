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
					<h1 class="m-0 text-bold">SENIOR HIGH ENROLLMENT UPLOAD</h1>
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
						<table class="table table-bordered table-hover" id="elemTable" style="width:100%;overflow:auto;">
							<div class="row">
								<div class="col-sm-6">
								</div>
								<div class="col-sm-6">
									<div class="table-danger text-dark text-center my-1" style="border-radius:50px; "><strong>NOT RECORDED IN DATABASE</div>
								</div>
							</div>
							<thead>
								<tr>
									<th rowspan="2">SCHOOL ID</th>
									<th colspan="2">GRADE 11 ABM</th>
									<th colspan="2">GRADE 11 HUMSS</th>
									<th colspan="2">GRADE 11 STEM</th>
									<th colspan="2">GRADE 11 GAS</th>
									<th colspan="2">GRADE 11 TVL</th>
									<th colspan="2">GRADE 11 SPORTS</th>
									<th colspan="2">GRADE 11 ARTS AND DESIGN</th>
									<th colspan="2">GRADE 12 ABM</th>
									<th colspan="2">GRADE 12 HUMSS</th>
									<th colspan="2">GRADE 12 STEM</th>
									<th colspan="2">GRADE 12 GAS</th>
									<th colspan="2">GRADE 12 TVL</th>
									<th colspan="2">GRADE 12 SPORTS</th>
									<th colspan="2">GRADE 12 ARTS AND DESIGN</th>
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
					uploadedEnrollment:true,type:"3"
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
		var g11_abm=[];
		var g11_humss=[];
		var g11_stem=[];
		var g11_tvl=[];
		var g11_sports=[];
		var g11_arts=[];
		var g11_gas=[];
		var g12_abm=[];
		var g12_humss=[];
		var g12_stem=[];
		var g12_tvl=[];
		var g12_sports=[];
		var g12_arts=[];
		var g12_gas=[];
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
					
					//column
					var startRow = '';
					var schidCol = '';
					//grade11
					var abm_11col = '';
					var humss_11col = '';
					var tvl_11col = '';
					var sports_11col = '';
					var arts_11col = '';
					var gas_11col = '';
					var stem_11col = '';
					//grade 12
					var abm_12col = '';
					var humss_12col = '';
					var tvl_12col = '';
					var sports_12col = '';
					var arts_12col = '';
					var gas_12col = '';
					var stem_12col = '';
					
					//values array
					var school_id = [];
					//grade11
					var abm_11m = [];
					var abm_11f = [];
					var humss_11m = [];
					var humss_11f = [];
					var tvl_11m = [];
					var tvl_11f = [];
					var sports_11m = [];
					var sports_11f = [];
					var arts_11m = [];
					var arts_11f = [];
					var gas_11m = [];
					var gas_11f = [];
					var stem_11m = [];
					var stem_11f = [];
					//grade12
					var abm_12m = [];
					var abm_12f = [];
					var humss_12m = [];
					var humss_12f = [];
					var tvl_12m = [];
					var tvl_12f = [];
					var sports_12m = [];
					var sports_12f = [];
					var arts_12m = [];
					var arts_12f = [];
					var gas_12m = [];
					var gas_12f = [];
					var stem_12m = [];
					var stem_12f = [];

					for(var row = 1; row <= sheet_data.length-1;row++){
						for(var col = 0; col <= sheet_data[row].length;col++){
							var headerName = sheet_data[row][col];
							switch(headerName){
								case "SCH. ID":
									schidCol = col;
									startRow = row+1;
									break;
								case "School_id":
									schidCol = col;
									startRow = row+1;
									break;
								case "Grade 11 ABM":
									abm_11col = col;
									break;
								case "Grade 11 HUMSS":
									humss_11col = col;
									break;
								case "Grade 11 STEM":
									stem_11col = col;
									break;
								case "Grade 11 GAS":
									gas_11col = col;
									break;
								case "Grade 11 TVL":
									tvl_11col = col;
									break;
								case "Grade 11 SPORTs":
									sports_11col = col;
									break;
								case "Grade 11 ARTs & DESIGN":
									arts_11col = col;
									break;
								case "Grade 12 ABM":
									abm_12col = col;
									break;
								case "Grade 12 HUMSS":
									humss_12col = col;
									break;
								case "Grade 12 STEM":
									stem_12col = col;
									break;
								case "Grade 12 GAS":
									gas_12col = col;
									break;
								case "Grade 12 TVL":
									tvl_12col = col;
									break;
								case "Grade 12 SPORTs":
									sports_12col = col;
									break;
								case "Grade 12 ARTs & DESIGN":
									arts_12col = col;
									break;
							}
							
							if(parseInt(schidCol) == col && row > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									school_id.push(sheet_data[row][col])
								}
							}
							//grade 11 abm
							if(parseInt(abm_11col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									abm_11m.push(sheet_data[row-1][col])
									abm_11f.push(sheet_data[row-1][col+1])
								}
							}
							//grade11 hums
							if(parseInt(humss_11col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									humss_11m.push(sheet_data[row-1][col])
									humss_11f.push(sheet_data[row-1][col+1])
								}
							}
							//grade11  tvl
							if(parseInt(tvl_11col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									tvl_11m.push(sheet_data[row-1][col])
									tvl_11f.push(sheet_data[row-1][col+1])
								}
							}
							//grade11 sports
							if(parseInt(sports_11col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									sports_11m.push(sheet_data[row-1][col])
									sports_11f.push(sheet_data[row-1][col+1])
								}
							}
							//grade11 arts 
							if(parseInt(arts_11col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									arts_11m.push(sheet_data[row-1][col])
									arts_11f.push(sheet_data[row-1][col+1])
								}
							}
							//grade11 gas
							if(parseInt(gas_11col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									gas_11m.push(sheet_data[row-1][col])
									gas_11f.push(sheet_data[row-1][col+1])
								}
							}
							//grade11 stem
							if(parseInt(stem_11col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									stem_11m.push(sheet_data[row-1][col])
									stem_11f.push(sheet_data[row-1][col+1])
								}
							}
							//grade 12 abm
							if(parseInt(abm_12col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									abm_12m.push(sheet_data[row-1][col])
									abm_12f.push(sheet_data[row-1][col+1])
								}
							}
							//grade12 hums
							if(parseInt(humss_12col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									humss_12m.push(sheet_data[row-1][col])
									humss_12f.push(sheet_data[row-1][col+1])
								}
							}
							//grade12  tvl
							if(parseInt(tvl_12col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									tvl_12m.push(sheet_data[row-1][col])
									tvl_12f.push(sheet_data[row-1][col+1])
								}
							}
							//grade12 sports
							if(parseInt(sports_12col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									sports_12m.push(sheet_data[row-1][col])
									sports_12f.push(sheet_data[row-1][col+1])
								}
							}
							//grade12 arts 
							if(parseInt(arts_12col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									arts_12m.push(sheet_data[row-1][col])
									arts_12f.push(sheet_data[row-1][col+1])
								}
							}
							//grade12 gas
							if(parseInt(gas_12col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									gas_12m.push(sheet_data[row-1][col])
									gas_12f.push(sheet_data[row-1][col+1])
								}
							}
							//grade12 stem
							if(parseInt(stem_12col) == col && row-1 > parseInt(startRow)){
								if(sheet_data[row][col] != null){
									stem_12m.push(sheet_data[row-1][col])
									stem_12f.push(sheet_data[row-1][col+1])
								}
							}
						} 
					}
					if(abm_11col,humss_11col,tvl_11col,sports_11col,arts_11col,gas_11col,stem_11col,abm_12col,humss_12col,tvl_12col,sports_12col,arts_12col,gas_12col,stem_12col == ""){
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
						g11_abm.push(abm_11m,abm_11f);
						g11_humss.push(humss_11m,humss_11f);
						g11_stem.push(stem_11m,stem_11f);
						g11_tvl.push(tvl_11m,tvl_11f);
						g11_sports.push(sports_11m,sports_11f);
						g11_arts.push(arts_11m,arts_11f);
						g11_gas.push(gas_11m,gas_11f);
						g12_abm.push(abm_12m,abm_12f);
						g12_humss.push(humss_12m,humss_12f);
						g12_stem.push(stem_12m,stem_12f);
						g12_tvl.push(tvl_12m,tvl_12f);
						g12_sports.push(sports_12m,sports_12f);
						g12_arts.push(arts_12m,arts_12f);
						g12_gas.push(gas_12m,gas_12f);
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
			var table = $("#elemTable").DataTable(
				{
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					fixedColumns:   {
						left: 1,
					}
				} 
			);
			for(var iteration = 0;iteration <= data.length-1;iteration++){
				var trow = table.row.add([contschoolid[0][iteration],g11_abm[0][iteration],g11_abm[1][iteration],g11_humss[0][iteration],g11_humss[1][iteration],g11_stem[0][iteration],g11_stem[1][iteration],g11_gas[0][iteration],g11_gas[1][iteration],g11_tvl[0][iteration],g11_tvl[1][iteration],g11_sports[0][iteration],g11_sports[1][iteration],g11_arts[0][iteration],g11_arts[1][iteration],g12_abm[0][iteration],g12_abm[1][iteration],g12_humss[0][iteration],g12_humss[1][iteration],g12_stem[0][iteration],g12_stem[1][iteration],g12_gas[0][iteration],g12_gas[1][iteration],g12_tvl[0][iteration],g12_tvl[1][iteration],g12_sports[0][iteration],g12_sports[1][iteration],g12_arts[0][iteration],g12_arts[1][iteration]]).draw().node();
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
				var temparray = [contschoolid[0][x],g11_abm[0][x],g11_abm[1][x],g11_humss[0][x],g11_humss[1][x],g11_stem[0][x],g11_stem[1][x],g11_gas[0][x],g11_gas[1][x],g11_tvl[0][x],g11_tvl[1][x],g11_sports[0][x],g11_sports[1][x],g11_arts[0][x],g11_arts[1][x],g12_abm[0][x],g12_abm[1][x],g12_humss[0][x],g12_humss[1][x],g12_stem[0][x],g12_stem[1][x],g12_gas[0][x],g12_gas[1][x],g12_tvl[0][x],g12_tvl[1][x],g12_sports[0][x],g12_sports[1][x],g12_arts[0][x],g12_arts[1][x]];
				schoolEnrollment.push(temparray);
			}
			$.ajax({
				url:"uploadEnrollment.php",
				type:"post",
				data:{shs:schoolEnrollment,schoolyear:val,month:month},
				success:function(returnedData){
					console.log(returnedData)
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
