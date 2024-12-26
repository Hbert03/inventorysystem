<?php
include('../../config/config_path.php');
include('../../config/fdatabase.php');
session_start(); 

$lastViewedTimestamp = isset($_SESSION['last_viewed']) ? $_SESSION['last_viewed'] : null;


$query = "SELECT MAX(date_t) as latest_entry FROM depedldn_ams.asset WHERE fund_source IN ('CO', 'RO')";
$result = $fconn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $latestEntry = $row['latest_entry'];
    $newData = (!$lastViewedTimestamp || strtotime($latestEntry) > strtotime($lastViewedTimestamp));
    echo json_encode(['newData' => $newData]);
} else {
    echo json_encode(['newData' => false, 'error' => $fconn->error]);
}
?>
