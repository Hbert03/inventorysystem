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
		<div class="content-header mb-2 pb-1">
		  <div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-bold">ENROLLMENT VIEW</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="homepage_planning.php">Home</a></li>
						<li class="breadcrumb-item active">Enrollment View</li>
					</ol>
				</div>
			</div>
		  </div>
		</div>
        <section class="content">
			<div class="row">
				<div class="col-sm-3">
					<div class="container border border-danger py-2 px-2" id="uploadingContainer">
						<div class="container mb-2">
							<label>TYPE</label>
							<select id="type" class="form-control select2 mb-2" onchange="showYear(this.value)">
								<option value="">
									Select Type
								</option>
								<option value="1">
									Elementary
								</option>
								<option value="2">
									Junior High School
								</option>
								<option value="3">
									Senior High School
								</option>
								
							</select>
						</div>
						<div class="container mb-2">
						<label>SCHOOL YEAR</label>
							<select id="schoolyear" class="form-control select2 mb-2" onchange="showMonth(this.value)">
								<option value="">
									Select School Year
								</option>
							</select>
						</div>
						<div class="container mb-1" style>
							<label>MONTH</label>
							<select type="month" class="form-control select2 mb-2" id="monthEnroll" onchange="showEnrollment()">
								<option value="">Select Month</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-sm-12 mt-2">
					<div class="container-fluid" id="tableCont" style="display:none;">
						<div class="container-fluid text-left px-0 py-0 my-2" id="buttons"></div>
						<table class="table table-hover table-bordered" id="elemTable" style="width:100%;overflow:auto;">
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
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<!--junior high-->
				<div class="col-sm-12 mt-2">
					<div class="container-fluid" id="tablejhsCont" style="display:none;">
					<div class="container-fluid text-left px-0 py-0 mb-2" id="JHSbutton"></div>
						<table class="table table-hover table-bordered" id="jhsTable" style="width:100%;overflow:auto;">
							<thead>
								<tr>
									<th rowspan="2">SCHOOL ID</th>
									<th colspan="2">GRADE 7</th>
									<th colspan="2">GRADE 8</th>
									<th colspan="2">GRADE 9</th>
									<th colspan="2">GRADE 10</th>
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
								</tr>
							</thead>
						</table>
					</div>
				</div>
				<!--senior high-->
				<div class="col-sm-12 mt-2">
					<div class="container-fluid" id="tableshsCont" style="display:none;">
					<div class="container-fluid text-left px-0 py-0 mb-2" id="shsbuttons"></div>
						<table class="table table-hover table-bordered" id="shsTable" style="width:100%;overflow:auto;">
							<thead>
								<tr>
									<th rowspan="3">SCHOOL ID</th>
									<th colspan="4">ABM</th>
									<th colspan="4">HUMS</th>
									<th colspan="4">STEM</th>
									<th colspan="4">GAS</th>
									<th colspan="4">TVL</th>
									<th colspan="4">SPORTS</th>
									<th colspan="4">ARTS</th>
								</tr>
								<tr>
									<th colspan="2">GRADE 11</th>
									<th colspan="2">GRADE 12</th>
									<th colspan="2">GRADE 11</th>
									<th colspan="2">GRADE 12</th>
									<th colspan="2">GRADE 11</th>
									<th colspan="2">GRADE 12</th>
									<th colspan="2">GRADE 11</th>
									<th colspan="2">GRADE 12</th>
									<th colspan="2">GRADE 11</th>
									<th colspan="2">GRADE 12</th>
									<th colspan="2">GRADE 11</th>
									<th colspan="2">GRADE 12</th>
									<th colspan="2">GRADE 11</th>
									<th colspan="2">GRADE 12</th>
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
		function showEnrollment(){
			var month = document.getElementById('monthEnroll').value;
			var schyear = document.getElementById('schoolyear').value;
			var type = document.getElementById('type').value;
			loader();
			$.ajax({
				url:"uploadEnrollment.php",
				type:"post",
				data:{tableShow:true,month:month,schyear:schyear,type:type},
				success:populateTable,
			})
		}
		function populateTable(data){
			var type = document.getElementById('type').value;
			var enrollment = JSON.parse(data);
			//elementary
			if(type == '1'){
				//clear and hide other table
				var totalkm = 0;
				var totalkf = 0;
				var total1m = 0;
				var total1f = 0;
				var total2m = 0;
				var total2f= 0;
				var total3m = 0;
				var total3f = 0;
				var total4m = 0;
				var total4f = 0;
				var total5m = 0;
				var total5f = 0;
				var total6m = 0;
				var total6f = 0;
				var totalngm = 0;
				var totalngf = 0;

				var jhstable = $("#jhsTable").DataTable();
					jhstable.clear().draw();
					document.getElementById("tablejhsCont").style.display="none";
				var shstable = $("#shsTable").DataTable();
					shstable.clear().draw();
					document.getElementById("tableshsCont").style.display="none";
			
				var table = $("#elemTable").DataTable();
				//clear previous data
					table.clear().draw();
				document.getElementById("tableCont").style.display = "block";
				for(var x = 0; x <= enrollment.length-1;x++){
					table.row.add([enrollment[x][0],enrollment[x][1],enrollment[x][2],enrollment[x][3],enrollment[x][4],enrollment[x][5],enrollment[x][6],enrollment[x][7],enrollment[x][8],enrollment[x][9],enrollment[x][10],enrollment[x][11],enrollment[x][12],enrollment[x][13],enrollment[x][14],enrollment[x][15],enrollment[x][16]]).draw();
					totalkm = parseInt(totalkm) + parseInt(enrollment[x][1]);
					totalkf = parseInt(totalkf) + parseInt(enrollment[x][2]);
					total1m = total1m + parseInt(enrollment[x][3]);
					total1f = total1f + parseInt(enrollment[x][4]);
					total2m = total2m + parseInt(enrollment[x][5]);
					total2f = total2f + parseInt(enrollment[x][6]);
					total3m = total3m + parseInt(enrollment[x][7]);
					total3f = total3f + parseInt(enrollment[x][8]);
					total4m = total4m + parseInt(enrollment[x][9]);
					total4f = total4f + parseInt(enrollment[x][10]);
					total5m = total5m + parseInt(enrollment[x][11]);
					total5f = total5f + parseInt(enrollment[x][12]);
					total6m = total6m + parseInt(enrollment[x][13]);
					total6f = total6f + parseInt(enrollment[x][14]);
					totalngm = totalngm + parseInt(enrollment[x][15]);
					totalngf = totalngf + parseInt(enrollment[x][16]);
				}
				//var lastrow = table.row.add(["TOTAL:",totalkm,totalkf,total1m,total1f,total2m,total2f,total3m,total3f,total4m,total4f,total5m,total5f,total6m,total6f,totalngm,totalngf]).draw().node();
				table.buttons().container().appendTo('#buttons');
				
				$(table.table().footer()).html('<tr class="text-primary">'+
												'<th>TOTAL:</th>'+
												'<th>'+totalkm.toLocaleString()+'</th>'+
												'<th>'+totalkf.toLocaleString()+'</th>'+
												'<th>'+total1m.toLocaleString()+'</th>'+
												'<th>'+total1f.toLocaleString()+'</th>'+
												'<th>'+total2m.toLocaleString()+'</th>'+
												'<th>'+total2f.toLocaleString()+'</th>'+
												'<th>'+total3m.toLocaleString()+'</th>'+
												'<th>'+total3f.toLocaleString()+'</th>'+
												'<th>'+total4m.toLocaleString()+'</th>'+
												'<th>'+total4f.toLocaleString()+'</th>'+
												'<th>'+total5m.toLocaleString()+'</th>'+
												'<th>'+total5f.toLocaleString()+'</th>'+
												'<th>'+total6m.toLocaleString()+'</th>'+
												'<th>'+total6f.toLocaleString()+'</th>'+
												'<th>'+totalngm.toLocaleString()+'</th>'+
												'<th>'+totalngf.toLocaleString()+'</th>'+
												'</tr>');
				//$(lastrow).addClass("text-bold");
				swal.close();
			}else if(type == '2'){
				var elemtable = $("elemTable").DataTable();
					elemtable.clear().draw();
					document.getElementById("tableCont").style.display = "none";
				var shstable = $("#shsTable").DataTable();
					shstable.clear().draw();
					document.getElementById("tableshsCont").style.display="none";
				var table = $("#jhsTable").DataTable();
				//clear previous data
					table.clear().draw();
				document.getElementById("tablejhsCont").style.display = "block";
				//sch_id,7m,7f,8m,8f,9m,9f,10m,10f
				//1	,2 , 3, 4, 5, 6, 7, 8, 9
				var total7m = 0;
				var total7f = 0;
				var total8m = 0;
				var total8f = 0;
				var total9m = 0;
				var total9f = 0;
				var total10m = 0;
				var total10f = 0;

				for(var x = 0; x <= enrollment.length-1;x++){
					table.row.add([enrollment[x][0],enrollment[x][1],enrollment[x][2],enrollment[x][3],enrollment[x][4],enrollment[x][5],enrollment[x]
					[6],enrollment[x][7],enrollment[x][8]]).draw();
					total7m = total7m + parseInt(enrollment[x][1]);
					total7f = total7f + parseInt(enrollment[x][2]);
					total8m = total8m + parseInt(enrollment[x][3]);
					total8f = total8f + parseInt(enrollment[x][4]);
					total9m = total9m + parseInt(enrollment[x][5]);
					total9f = total9f + parseInt(enrollment[x][6]);
					total10m = total10m + parseInt(enrollment[x][7]);
					total10f = total10f + parseInt(enrollment[x][8]);

				}
				$(table.table().footer()).html('<tr class="text-primary">'+
												'<th>TOTAL:</th>'+
												'<th>'+total7m.toLocaleString()+'</th>'+
												'<th>'+total7f.toLocaleString()+'</th>'+
												'<th>'+total8m.toLocaleString()+'</th>'+
												'<th>'+total8f.toLocaleString()+'</th>'+
												'<th>'+total9m.toLocaleString()+'</th>'+
												'<th>'+total9f.toLocaleString()+'</th>'+
												'<th>'+total10m.toLocaleString()+'</th>'+
												'<th>'+total10m.toLocaleString()+'</th>'+
												'</tr>');
				table.buttons().container().appendTo('#JHSbutton');
				swal.close();
			}else if(type == '3'){
				//clear and hide other table
				var jhstable = $("#jhsTable").DataTable();
					jhstable.clear().draw();
					document.getElementById("tablejhsCont").style.display="none";
				var elemtable = $("elemTable").DataTable();
					elemtable.clear().draw();
					document.getElementById("tableCont").style.display = "none";

				var table = $("#shsTable").DataTable();
				//clear previous data
					table.clear().draw();
				document.getElementById("tableshsCont").style.display = "block";
				//abm,humss,stem,gas,tvl,sports,arts
				//grde11_m_abm ,grade11_f_abm - 1,2
				//grde11_m_humss ,grade11_f_humss - 5,6 
				//grde11_m_stem ,grade11_f_stem - 9,10
				//grde11_m_gas ,grade11_f_gas - 13,14
				//grde11_m_tvl ,grade11_f_tvl - 17,18
				//grde11_m_sports ,grade11_f_sports - 21,22 
				//grde11_m_arts ,grade11_f_arts - 25,26
				//----------------------------------------GRADE 12
				//grade12_m_abm,grade12_f_abm - 3,4
				//grade12_m_humss,grade12_f_humss - 7,8
				//grade12_m_stem,grade12_f_stem - 11,12
				//grade12_m_gas,grade12_f_gas - 15,16
				//grade12_m_tvl,grade12_f_tvl - 19,20
				//grade12_m_sports,grade12_f_sports - 23,24
				//grade12_m_arts,grade12_f_arts - 27,28
				//abm
				var totalabm11m = 0;
				var totalabm11f = 0;
				var totalabm12m = 0;
				var totalabm12f = 0;
				var totalhumss11m = 0;
				var totalhumss11f = 0;
				var totalhumss12m = 0;
				var totalhumss12f = 0;
				var totalstem11m = 0;
				var totalstem11f = 0;
				var totalstem12m = 0;
				var totalstem12f = 0;
				var totalgas11m = 0;
				var totalgas11f = 0;
				var totalgas12m = 0;
				var totalgas12f = 0;
				var totaltvl11m = 0;
				var totaltvl11f = 0;
				var totaltvl12m = 0;
				var totaltvl12f = 0;
				var totalsports11m = 0;
				var totalsports11f = 0;
				var totalsports12m = 0;
				var totalsports12f = 0;
				var totalarts11m = 0;
				var totalarts11f = 0;
				var totalarts12m = 0;
				var totalarts12f = 0;
			
				for(var x = 0; x <= enrollment.length-1;x++){
					table.row.add([enrollment[x][0],enrollment[x][1],enrollment[x][2],enrollment[x][3],enrollment[x][4],enrollment[x][5],enrollment[x]
					[6],enrollment[x][7],enrollment[x][8],enrollment[x][9],enrollment[x][10],enrollment[x][11],enrollment[x][12],enrollment[x][13],enrollment[x][14],enrollment[x][15],enrollment[x][16],enrollment[x][17],enrollment[x][18],enrollment[x][19],enrollment[x][20],enrollment[x][21],enrollment[x][22],enrollment[x][23],enrollment[x][24],enrollment[x][25],enrollment[x][26],enrollment[x][27],enrollment[x][28]]).draw();
					
					totalabm11m = totalabm11m + parseInt(enrollment[x][1]);
					totalabm11f = totalabm11f + parseInt(enrollment[x][2]);
					totalabm12m = totalabm12m + parseInt(enrollment[x][3]);
					totalabm12f = totalabm12f + parseInt(enrollment[x][4]);
					totalhumss11m = totalhumss11m + parseInt(enrollment[x][5]);
					totalhumss11f = totalhumss11f + parseInt(enrollment[x][6]);
					totalhumss12m = totalhumss12m + parseInt(enrollment[x][7]);
					totalhumss12f = totalhumss12f + parseInt(enrollment[x][8]);
					totalstem11m = totalstem11m + parseInt(enrollment[x][9]);
					totalstem11f = totalstem11f + parseInt(enrollment[x][10]);
					totalstem12m = totalstem12m + parseInt(enrollment[x][11]);
					totalstem12f = totalstem12f + parseInt(enrollment[x][12]);
					totalgas11m = totalgas11m + parseInt(enrollment[x][13]);
					totalgas11f = totalgas11f + parseInt(enrollment[x][14]);
					totalgas12m = totalgas12m + parseInt(enrollment[x][15]);
					totalgas12f = totalgas12f + parseInt(enrollment[x][16]);
					totaltvl11m = totaltvl11m + parseInt(enrollment[x][13]);
					totaltvl11f = totaltvl11f + parseInt(enrollment[x][14]);
					totaltvl12m = totaltvl11m	 + parseInt(enrollment[x][15]);
					totaltvl12f = totaltvl12f + parseInt(enrollment[x][16]);
					totalsports11m = totalsports11m + parseInt(enrollment[x][17]);
					totalsports11f = totalsports11f + parseInt(enrollment[x][18]);
					totalsports12m = totalsports11m	 + parseInt(enrollment[x][19]);
					totalsports12f = totalsports12f + parseInt(enrollment[x][20]);
					totalarts11m = totalarts11m + parseInt(enrollment[x][21]);
					totalarts11f = totalarts11f + parseInt(enrollment[x][22]);
					totalarts12m = totalarts11m	 + parseInt(enrollment[x][23]);
					totalarts12f = totalarts12f + parseInt(enrollment[x][24]);
				}
				$(table.table().footer()).html('<tr class="text-primary">'+
												'<th>TOTAL:</th>'+
												'<th>'+totalabm11m.toLocaleString()+'</th>'+
												'<th>'+totalabm11f.toLocaleString()+'</th>'+
												'<th>'+totalabm12m.toLocaleString()+'</th>'+
												'<th>'+totalabm12f.toLocaleString()+'</th>'+
												'<th>'+totalhumss11m.toLocaleString()+'</th>'+
												'<th>'+totalhumss11f.toLocaleString()+'</th>'+
												'<th>'+totalhumss12m.toLocaleString()+'</th>'+
												'<th>'+totalhumss12f.toLocaleString()+'</th>'+
												'<th>'+totalstem11m.toLocaleString()+'</th>'+
												'<th>'+totalstem11f.toLocaleString()+'</th>'+
												'<th>'+totalstem12m.toLocaleString()+'</th>'+
												'<th>'+totalstem12f.toLocaleString()+'</th>'+
												'<th>'+totalgas11m.toLocaleString()+'</th>'+
												'<th>'+totalgas11f.toLocaleString()+'</th>'+
												'<th>'+totalgas12m.toLocaleString()+'</th>'+
												'<th>'+totalgas12f.toLocaleString()+'</th>'+
												'<th>'+totaltvl11m.toLocaleString()+'</th>'+
												'<th>'+totaltvl11f.toLocaleString()+'</th>'+
												'<th>'+totaltvl12m.toLocaleString()+'</th>'+
												'<th>'+totaltvl12f.toLocaleString()+'</th>'+
												'<th>'+totalsports11m.toLocaleString()+'</th>'+
												'<th>'+totalsports11f.toLocaleString()+'</th>'+
												'<th>'+totalsports12m.toLocaleString()+'</th>'+
												'<th>'+totalsports12f.toLocaleString()+'</th>'+
												'<th>'+totalarts11m.toLocaleString()+'</th>'+
												'<th>'+totalarts11f.toLocaleString()+'</th>'+
												'<th>'+totalarts12m.toLocaleString()+'</th>'+
												'<th>'+totalarts12f.toLocaleString()+'</th>'+
												'</tr>');
				table.buttons().container().appendTo('#JHSbutton');
				swal.close();
			}
			
		}
		function showYear(val){
			var type = document.getElementById('type').value;
			$("#schoolyear").empty();
			$("#monthEnroll").empty();
			//continue here
			$.ajax({
				url:"uploadEnrollment.php",
				type:"post",
				data:{
					schtype:true,type:val
				},
				success:function(data){
					console.log(data);
					var options = JSON.parse(data);
					var select = document.getElementById('schoolyear');
					var optBase = document.createElement('option');
						optBase.value="";
						optBase.innerHTML = "Select School Year";
						select.appendChild(optBase);
					for (var x = 0; x<= options.length-1;x++){
						var opt = document.createElement('option');
						opt.value = options[x];
						opt.innerHTML = options[x];
						select.appendChild(opt);
					}
				}
			})
		}
		function showMonth(val){
			document.getElementById('monthEnroll').style.display = "none";
			$("#monthEnroll").empty();
			$.ajax({
				url:"uploadEnrollment.php",
				type:"post",
				data:{schYear:val},
				success:function(data){
					var options = JSON.parse(data);
					var select = document.getElementById('monthEnroll');
					var optBase = document.createElement('option');
						optBase.value = "";
						optBase.innerHTML = "Select Month";
						select.appendChild(optBase);
					for(var x = 0; x <= options.length-1;x++){
						var opt = document.createElement('option');
						opt.value = options[x];
						opt.innerHTML = getMonth(options[x]);
						select.appendChild(opt);
					}
					select.style.display = "block";
				}
			})
		}
		function loader(){
			Swal.fire({
				html: '<p><i class="fas fa-spinner fa-pulse fa-6x"></i></p><p>Loading please wait..</p>',
				showConfirmButton: false,
				allowOutsideClick: false,
			});
		}
		$(function (){
			document.getElementById('elemTable').createTFoot().insertRow(0);
			document.getElementById('jhsTable').createTFoot().insertRow(0);
			document.getElementById('shsTable').createTFoot().insertRow(0);
			$("#elemTable").DataTable(
				{
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					fixedColumns:   {
						left: 1,
					},
					buttons: [
     				   'copy'
    				]
				} 
			);
			$("#jhsTable").DataTable(
				{
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					fixedColumns:   {
						left: 1,
					},
					buttons: [
     				   'copy'
    				]
				} 
			);
			$("#shsTable").DataTable(
				{
					scrollX:        true,
					scrollCollapse: true,
					paging:         true,
					fixedColumns:   {
						left: 1,
					},
					buttons: [
     				   'copy'
    				]
				} 
			);
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
