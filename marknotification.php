<?php
include('../../config/config_path.php');
include('../../config/fdatabase.php');
session_start();
$_SESSION['last_viewed'] = date('Y-m-d H:i:s'); 
echo json_encode(['status' => 'success']);
?>
