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
   <!-- Main Sidebar Container -->

</div>
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
						<td>'.$amsRow['description'].'</td>
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
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
	  </div>
    </section>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->

  <!-- /.control-sidebar -->
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
      "buttons": ["copy", "csv", "excel", "colvis"]
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
