<?php
include('../../config/config_path.php');
include('../../config/fdatabase.php');

session_start();
$lastViewedTimestamp = isset($_SESSION['last_viewed']) ? $_SESSION['last_viewed'] : '1970-01-01 00:00:00';

$query = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name) AS fullname 
          FROM depedldn_ams.asset a 
          INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer 
          WHERE a.date_t > '$lastViewedTimestamp' AND a.fund_source IN ('CO', 'RO')
          ORDER BY a.date_t DESC";

$result = $fconn->query($query);

if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['data' => $data]);
} else {
    echo json_encode(['error' => $fconn->error]);
}
?>
