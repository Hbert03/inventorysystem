<?php
session_start();

if (isset($_SESSION['personnel']) || isset($_SESSION['admin']) || isset($_SESSION['employee_name']) || isset($_SESSION['user_id']) || isset($_SESSION['office_id']) || isset($_SESSION['office_id'])) {
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


   .select-input{
    z-index: 2000 !important;
   }

   .select-dropdown{
    z-index: 10 !important;
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

  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <link  rel="stylesheet" href="plugins/select2/css/select2.css"></link>
  <link  rel="stylesheet" href="plugins/toastr/toastr.min.css"></link>
 <link  rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.css"></link>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'header_menu.php';
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'main_sidebar.php';
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'sidemenu.php';
    include $_SERVER['DOCUMENT_ROOT'] . AMS_PATH . 'dashboard.php';
 ?>
   <!-- Main Sidebar Container -->

</div>

 
    <!-- Main content -->
   
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- AdminLTE App -->
<script src="plugins/select2/js/select2.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/xlsx.full.min.js"></script>
<script src="script1.js"></script>  
</body>
</html>
