<?php
session_start();

if (isset($_SESSION['personnel']) || isset($_SESSION['admin']) || isset($_SESSION['employee_name']) || isset($_SESSION['user_id']) || isset($_SESSION['office_id']) || isset($_SESSION['account_id'])) {
    if (!include('../../config/config_path.php')) {
        include('../../config/config_path.php');
    }
} else {
    // Redirect to the login page if no valid session is found
    echo '<script>window.open("index.php","_self")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>


<style>
    body{
        overflow-x:hidden;
    }
    
</style>
  <title>LDN | INVENTORY SYSTEM</title>
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
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.all.min.js">
  <link  rel="stylesheet" href="plugins/select2/css/select2.css"></link>
  <link  rel="stylesheet" href="plugins/toastr/toastr.min.css"></link>
 <link  rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.css"></link>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'header_index.php';
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'main_sidebar.php';
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'sidemenu_ao.php';
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
   

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
 
            <div class="card">
              <div class="card-header">
                
                <h3 class="card-title"  style="margin-right:6px">
                LIST OF ENTRY            
              </h3>
              <h3 class="card-title" id="school_name2" style="color:red">(No Schools Selected)</h3>
              <button class="btn btn-info float-right" id="totalUnitMeas"></button>
            
              <!-- <button type="button" class="btn btn-primary btn-sm float-right " data-toggle="modal" data-target="#exampleModal">
                    ADD ASSET <i class="fa fa-plus"></i>
                  </button> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body w-100">
              <select class="form-control w-25 mb-3 sort_ao">Select</select>
                <table id="show_ao_entry" class="table table-bordered table-striped">
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"  style="margin-right:6px">
                LIST OF LAND ENTRY            
              </h3>
              <h3 class="card-title" id="school_name3" style="color:red">(No Schools Selected)</h3>
              <button class="btn btn-info float-right" id="totalUnitMeas1"></button>
              <!-- <button type="button" class="btn btn-primary btn-sm float-right " data-toggle="modal" data-target="#exampleModal">
                    ADD ASSET <i class="fa fa-plus"></i>
                  </button> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body w-100">
                <table id="show_ao_land" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                    <th>Description </th>
                      <th>Property Number</th>
                      <th>Remarks</th>
                      <th>Unit Value</th>
                      <th>Date Titled</th>
                      <th>Date Acquired</th>
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



 

<?php
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'invent_footer.php';

 ?>
<script>
    var userId = "<?php echo $_SESSION['account_id'] ?? ''; ?>";
</script>
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
<!-- AdminLTE App -->
<script src="plugins/select2/js/select2.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="script1.js"></script>  
</body>
</html>
