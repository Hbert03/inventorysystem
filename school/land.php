
<?php
    session_start();
    if(isset($_SESSION['personnel']) || isset($_SESSION['admin']) ){
        if (!include('../../../config/config_path.php')) {
            include('../../../config/config_path.php');
        }   
    }
    else {
        echo '<script>window.open("index.php","_self")</script>';    
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>LDN | AMS</title>
  <link rel="icon" href="dist/img/depedldn.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link  rel="stylesheet" href="../plugins/select2/css/select2.css"></link>
 <link  rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.css"></link>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'school/header_sch.php';
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'school/sch_main.php';
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'school/sch_sidemenu.php';
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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel"><b>ADD ASSETS/LAND</b></h2>
      </div>
      <div class="modal-body">
        <form id="addland" action="" method="POST"  enctype="multipart/form-data">
              <label for="examDropdown">Asset Type</label>
              <select class="form-control land" name="select1" required></select>
              <input type="text" class="form-control mb-1 mt-1" name="description" id="description" placeholder="Description">
						<input type="text" class="form-control mb-1" name="property_no" id="property_no" placeholder="Property No.">
						<input type="text" class="form-control mb-1" name="land_area" id="land_area" placeholder="Land Area">
						<input type="text" class="form-control mb-1" name="acquisition_cost" id="acquisition_cost" placeholder="Acquisition Cost">
            <label>Date Encoded</label>
            <input type="date" class="form-control mb-1" name="date" placeholder="Date Encoded">
            <label>Titled</label>
						<select class="form-control mb-1 " name="titled" id="titled" required>
							<option disabled selected>Select Titled</option>
							<option value="yes">Yes</option>
							<option value="no">No</option></select>
              <label>Date Titled</label>
						<input type="date" class="form-control mb-1" name="date_titled" id="date_titled" placeholder="Date Titled">
            <label>Date Acquired</label>
						<input type="date" class="form-control mb-1" name="date_acq" id="date_acq" placeholder="Date Acquired" required>
            <label>Remarks</label>
            <select class="form-control mb-1 " name="remarks" id="remarks" required>
            <option disabled selected>Remarks</option>
							<option value="New/Good Condition/Funds">New/Good Condition/Funds</option>
							<option value="Need Repair">Need Repair</option>
							<option value="Defective - Repairable">Defective - Repairable</option>
							<option value="Defective - Disposal">Defective - Disposal</option>
            </select>
						<button type="button" class="btn btn-primary btn-sm btn-block mt-2 saveland" >SAVE</button>
						<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" >CANCEL</button>
        </form> 
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                 Land
                </h3>
                <button class="btn btn-info float-right" id="totalUnitMeas"></button>
              </div>
              <!-- /.card-header -->
              <div class="card-body w-100">
                <table id="showLand_sch" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Description </th>
                      <th>Property No.</th>
                      <th>Land Area</th>
                      <th>Acquisition Cost</th>
                      <th>Titled</th>
                      <th>remarks</th>
                      <th>School</th>
                      <th>Date Acquired</th>
                      <th>Date Encoded</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody  style="font-family: 'Oswald', sans-serif; font-optical-sizing: auto; font-weight: <weight>; font-style: normal;">
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
  <!-- /.content-wrapper -->


<?php
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'invent_footer.php';
 ?>
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
<!-- AdminLTE App -->
<script src="../plugins/select2/js/select2.min.js"></script>
<script src="../plugins/select2/js/select2.full.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script src="../script1.js"></script>  
</body>
</html>
<?php

// if(isset($_POST['create_ams1'])){
//   $nowDate = date("Y-m-d H:i:s");
//   $user_id = $_SESSION['personnel'];
//   $select1 = $_POST['select1'];
//   $description = $_POST['description'].' '.'Titled:'.$_POST['titled'].' '.'Date Titled:'.$_POST['date_titled'];
//   $property_no = $_POST['property_no'];
//   $land_area = $_POST['land_area'];
//   $acquisition_cost = $_POST['acquisition_cost'];
//   $titled = $_POST['titled'];
//   $date_titled = $_POST['date_titled'];
//   $date = $_POST['date'];
//   $remarks = $_POST['remarks'];
//   $date_acq = $_POST['date_acq'];
//   $school_office = $_SESSION['school'];

//   $check_query = "SELECT * FROM asset WHERE description = '$description' AND land_area = '$land_area' AND property_no = '$property_no' AND remarks = '$remarks'";
//   $result = mysqli_query($fconn, $check_query);

//   if (mysqli_num_rows($result) == 0) {
//    $query = "INSERT INTO asset(asset_id,user_id,description,property_no,remarks, date_acquired, unit_meas,land_area,unit_val,titled,date_titled,school_office, date)VALUES
//     ('$select1','$user_id','$description','$property_no','$remarks', '$date_acq','$land_area','$land_area','$acquisition_cost','$titled','$date_titled','$school_office', '$date')";  
//     if(mysqli_query($fconn,$query)){
//       echo "<script>Swal.fire({
//         icon:'success',
//         title:'Asset Created',
//       })</script>";

//     }else{
//       echo "<script>Swal.fire({
//         icon:'error',
//         title:'Something went wrong',
//         html:'<p>Something went wrong while creating asset, If error persist contact your ICT</p><button class=\'btn btn-secondary btn-block\' onclick=\'swal.close()\'>CLOSE</button>',
// 			showConfirmButton:false,
// 			allowOutsideClick:true,
// 		}).then(()=>{window.open(location.href,'_self')})</script>";
// 	}
// 	}
// }
?>