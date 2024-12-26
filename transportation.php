
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
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link  rel="stylesheet" href="plugins/select2/css/select2.css"></link>
 <link  rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.css"></link>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">ADD ASSETS</h2>
      </div>
      <div class="modal-body">
        <form action="" method="POST"  enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
              <label for="examDropdown"></label>
              <select class="form-control transport1" name="select1" required></select>
              <input type="text" class="form-control mb-1 mt-2" name="type" id="type" placeholder="Type">
						<input type="text" class="form-control mb-1" name="brand" id="brand" placeholder="Brand">
						<input type="text" class="form-control mb-1" name="model" id="model" placeholder="Model">
						<input type="text" class="form-control mb-1" name="article" id="article" placeholder="Article">
						<input type="text" class="form-control mb-1" name="sn" id="sn" placeholder="Serial No.">
						<input type="text" class="form-control mb-1" name="property_no" id="property_no" placeholder="Property No.">
            <input type="text" class="form-control mb-1" name="stock" id="stock" placeholder="Stock No.">
						<input type="text" class="form-control mb-1" name="measurement" id="measurement" placeholder="Measurement">
						<input type="text" class="form-control mb-1" name="unit_value" id="unit_value" placeholder="Unit Value">
            </div>
            <div class="col-md-6">
              <label for="examDropdown"></label>
              <select class="form-control transport2 mb-1" name="select2" required></select>
              <input type="text" class="form-control mt-2 mb-1" name="qty_card" id="qty_card" placeholder="Qty Card">
						<input type="text" class="form-control mb-1" name="qty_count" id="qty_count" placeholder="Qty Count">
						<input type="text" class="form-control mb-1" name="useful_life" id="useful_life" placeholder="Usefull Life">
						<input type="text" class="form-control mb-1" name="qty_short" id="qty_short" placeholder="qty_short ">
						<input type="text" class="form-control mb-1" name="value_short" id="value_short" placeholder="value_short">
						<input type="date" class="form-control mb-1" name="date-input" id="date-input" placeholder="Acquisition Date" required>
						<input type="text" class="form-control mb-1" name="remarks" id="remarks" placeholder="Remarks">
						<input type="text" class="form-control mb-1" name="account_off" id="account_off" placeholder="Accountable Officer">  
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-sm btn-block mb-1" name="create_transportation">SAVE</button>
        </form> 
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                Transportation and Equipment
                </h3>
                <button class="btn btn-info float-right" id="totalUnitMeas"></button>
                <!-- <button type="button" class="btn btn-primary btn-sm float-right " data-toggle="modal" data-target="#exampleModal">
                    ADD FILES <i class="fa fa-plus"></i>
                  </button> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body w-100">
                <table id="showTable_transport" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                    <th>Description </th>
                      <th>Property Number</th>
                      <th>Unit Measure</th>
                      <th>Unit Value</th>
                      <th>Quantity Property Card</th>
                      <th>Quantity Physical Count</th>
                      <th>Shortage Quantity</th>
                      <th>Shortage Value</th>
                      <th>Date Acquired</th>
                      <th>remarks</th>
                      <th>Accountable Officer</th>
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
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
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Include Select2 JavaScript -->
    <script src="plugins/select2/js/select2.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
</head>
<script src="dist/js/adminlte.min.js"></script>
<script src="script1.js"></script>  
</body>
</html>

<?php    
if(isset($_POST['create_transportation'])){
  $nowDate = date("Y-m-d H:i:s");
  $user_id = $_SESSION['personnel'];
  $select1 = $_POST['select1'];
  $select2 = $_POST['select2'];
  $article = $_POST['article'];
  $type = $_POST['type'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $sn = $_POST['sn'];
  $useful_life = $_POST['useful_life'];
  $description = $type;
  $property_no = $_POST['property_no'];
  $stock = $_POST['stock'];
  $date = $_POST['date-input'];
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
    $query = "INSERT INTO asset(asset_id,user_id,asset_subid,article_id,asset_type,brand,model,asset_sn,useful_life,description,property_no,stock_no,unit_meas,unit_val,qty_property_card,qty_physical_count,shortage_qty,shortage_value,remarks,account_officer,date)VALUES
    ('$select1','$user_id','$select2','$article','$type','$brand','$model','$sn','$useful_life','$description','$property_no','$stock','$date','$unit_value','$qty_card', '$qty_count', '$qty_short','$value_short','$account_off','$remarks','$nowDate')";  
    if(mysqli_query($fconn,$query)){
      echo "<script>Swal.fire({
        icon:'success',
        title:'Asset Created',
      })</script>";

    }else{
      echo "<script>Swal.fire({
        icon:'error',
        title:'Something went wrong',
        html:'<p>Something went wrong while creating asset, If error persist contact your ICT</p><button class=\'btn btn-secondary btn-block\' onclick=\'swal.close()\'>CLOSE</button>',
			showConfirmButton:false,
			allowOutsideClick:true,
		})</script>";
	}
	}
}
?>

