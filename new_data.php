<?php
include('../../config/config_path.php');
include('../../config/fdatabase.php');

$query = "SELECT COUNT(*) AS newData FROM fund_sources WHERE notification_status = 1";
$result = $fconn->query($query);
$row = $result->fetch_assoc();

echo json_encode(['newData' => $row['newData'] > 0]);




<?php
// Database connection
include 'db_connect.php';

$query = "SELECT * FROM fund_sources WHERE notification_status = 1";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
?>

?>
