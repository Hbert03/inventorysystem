<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION['personnel']) || isset($_SESSION['admin']) ){
		if (!include('../../config/config_path.php')) {
			include('../../config/config_path.php');
		}	
	}
	else {
		echo '<script>window.open("index.php","_self")</script>';	
    }
?>
<html lang="en">
<head>
  <title>LDN | AMS</title>
  <link rel="icon" href="dist/img/depedldn.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
	include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'header_menu.php';
	include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'main_sidebar.php';
	include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'sidemenu.php';
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DepEd LDN - Asset Management System</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header" >
                <h3 class="card-title">
				<?php
					$title = $_SESSION['title'];					
					echo $title;
				?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table>
                  <thead>
                  <tr>
                    <th>Type</th>
					<th>Brand</th>
					<th>Model</th>
					<th>Serial No.</th>
                    <th>Property No.</th>
                    <th>Measurement</th>
					<th>Unit Value</th>
					
				  </tr>
				  </thead>
                  <tbody>
				  <tr><form method="POST">
						<td><input type="text" class="form-control" name="type" id="type" placeholder="Type"></td>
						<td><input type="text" class="form-control" name="brand" id="brand" placeholder="Brand"></td>
						<td><input type="text" class="form-control" name="model" id="model" placeholder="Model"></td>
						<td><input type="text" class="form-control" name="sn" id="sn" placeholder="Serial No."></td>
						<td><input type="text" class="form-control" name="property_no" id="property_no" placeholder="Property No."></td>
						<td><input type="text" class="form-control" name="measurement" id="measurement" placeholder="Measurement"></td>
						<td><input type="text" class="form-control" name="unit_value" id="unit_value" placeholder="Unit Value"></td>
					</tr>
				<thead>
				  <tr>
					
					<th>Qty Card</th>
					<th>Qty Count</th>
					<th>Useful Life</th>
					<th>Acquisition Date</th>
					<th>Remarks</th>
					<th>Accountable Officer</th>
					<th>Action</th>
                  </tr>
                </thead>
					<tr>
						<td><input type="text" class="form-control" name="qty_card" id="qty_card" placeholder="Qty Card"></td>
						<td><input type="text" class="form-control" name="qty_count" id="qty_count" placeholder="Qty Count"></td>
						<td><input type="text" class="form-control" name="useful_life" id="useful_life" placeholder="Usefull Life"></td>
						<td><input type="date" class="form-control" name="date-input" id="date-input" placeholder="Acquisition Date"></td>
						<td><input type="text" class="form-control" name="remarks" id="remarks" placeholder="Remarks"></td>
						<td><input type="text" class="form-control" name="account_off" id="account_off" placeholder="Accountable Officer"></td>
						<td><button type="submit" class="btn btn-success btn-sm btn-block" name="create_ams" >CREATE</button></td>
						</form>
						</tr>
                  </tfoot>
                </table>
              </div>
			  
			  
              <!-- /.card-body -->
            </div>
			<div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Article</th>
                    <th>Description</th>
                    <th>Property No.</th>
                    <th>Measurement</th>
					<th>Unit Value</th>
					<th>Qty Card</th>
					<th>Qty Count</th>
					<th>Qty Short</th>
					<th>Value Short</th>
					<th>Remarks</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php
					$amsDetails = $_SESSION['buttonDetails'];
					$ams = $amsDetails;
					$rowCount = '0';
					$amsIns = mysqli_query($fconn,$ams);
					while($amsRow = mysqli_fetch_array($amsIns,MYSQLI_ASSOC)){
					  $formatted_unit_val = '₱' . number_format($amsRow['unit_val'], 2, '.', ',');
					  echo '<tr>
							<td></td>
							<td>'.$amsRow['description'].'<br>Brand: '.$amsRow['brand'].'<br>Model: '.$amsRow['model'].'<br>SN: '.$amsRow['asset_sn'].'</td>
							<td>'.$amsRow['property_no'].'</td>
							<td>'.$amsRow['unit_meas'].'</td>
							<td>'.$formatted_unit_val.'</td>
							<td>'.$amsRow['qty_property_card'].'</td>
							<td>'.$amsRow['qty_physical_count'].'</td>
							<td>'.$amsRow['shortage_qty'].'</td>
							<td>'.$amsRow['shortage_value'].'</td>
							<td>'.$amsRow['remarks'].'</td>
						  </tr>';
					}
					?>
                  </tfoot>
                </table>
              </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<?php
	include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'invent_footer.php';
 ?>
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
	const table = document.getElementById("example1");
	for (let i = 1, row; row = table.rows[i]; i++) {
		row.cells[0].innerHTML = i;
	}
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel","colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
<?php
if(isset($_POST['create_ams'])){
  $nowDate = date("Y-m-d H:i:s");
  $user_id = $_SESSION['personnel'];
  $select1 = $_SESSION['select1'];
  $select2 = $_SESSION['select2'];
  $article = $_POST['article'];
  $type = $_POST['type'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $sn = $_POST['sn'];
  $useful_life = $_POST['useful_life'];
  $description = $type;
  $property_no = $_POST['property_no'];
  $measurement = $_POST['measurement'];
  $unit_value = $_POST['unit_value'];
  $qty_card = $_POST['qty_card'];
  $qty_count = $_POST['qty_count'];
  $qty_short = $_POST['qty_short'];
  $value_short = $_POST['value_short'];
  $remarks = $_POST['remarks'];
  $account_off = $_POST['account_off'];

  $check_query = "SELECT * FROM asset WHERE description = '$description' AND unit_val = '$unit_value' AND property_no = '$property_no' AND remarks = '$remarks'";
  $result = mysqli_query($fconn, $check_query);

  if (mysqli_num_rows($result) == 0) {
    $query = "INSERT INTO asset(asset_id,user_id,asset_subid,article_id,asset_type,brand,model,asset_sn,useful_life,description,property_no,unit_meas,unit_val,qty_property_card,qty_physical_count,shortage_qty,shortage_value,remarks,account_officer,date)VALUES
    ('$assetID','$user_id','$assetSubId','$article','$type','$brand','$model','$sn','$useful_life','$description','$property_no','$measurement','$unit_value','$qty_card', '$qty_count', '$qty_short','$value_short','$account_off','$remarks','$nowDate')";  
    if(mysqli_query($fconn,$query)){
      echo "<script>Swal.fire({
        icon:'success',
        title:'Asset Created',
        html:'<p>You have successfully created asset </p><button class=\'btn btn-secondary btn-block\' onclick=\'swal.close()\'>CLOSE</button>',
        showConfirmButton:false,
        allowOutsideClick:false,
      });
	  window.location.href = window.location.href;</script>";
    }else{
      echo "<script>Swal.fire({
        icon:'error',
        title:'Something went wrong',
        html:'<p>Something went wrong while creating asset, If error persist contact your ICT</p><button class=\'btn btn-secondary btn-block\' onclick=\'swal.close()\'>CLOSE</button>',
			showConfirmButton:false,
			allowOutsideClick:true,
		});
		window.location.href = window.location.href;</script>";
	}
	}
}
?>