<?php
// Database connection
include 'db_connect.php';

$query = "UPDATE fund_sources SET notification_status = 0 WHERE notification_status = 1";
$conn->query($query);

echo json_encode(['success' => true]);
?>
