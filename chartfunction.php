<?php
include('../../config/config_path.php');
include('../../config/fdatabase.php');

header('Content-Type: application/json');

function fetchData() {
    global $fconn;
    $data = ['labels' => [], 'values' => []];

    $assets = [
        ['label' => 'School Building', 'asset_id' => 1, 'asset_subid' => 1],
        ['label' => 'Other Structures', 'asset_id' => 1, 'asset_subid' => 2],
        ['label' => 'Machinery', 'asset_id' => 2, 'asset_subid' => 3],
        ['label' => 'Office Equipment', 'asset_id' => 2, 'asset_subid' => 4],
        ['label' => 'ICT Equipment', 'asset_id' => 2, 'asset_subid' => 5],
        ['label' => 'Agricultural & Forestry Equipment', 'asset_id' => 2, 'asset_subid' => 6],
        ['label' => 'Sports Equipment', 'asset_id' => 2, 'asset_subid' => 7],
        ['label' => 'Technical & Scientific Equipment', 'asset_id' => 2, 'asset_subid' => 8],
        ['label' => 'Motor Vehicle', 'asset_id' => 3, 'asset_subid' => 9],
        ['label' => 'Furnitures and Fixtures', 'asset_id' => 4, 'asset_subid' => 10],
        ['label' => 'Books', 'asset_id' => 4, 'asset_subid' => 11],
        ['label' => 'Other Property Plant and Equipment', 'asset_id' => 5, 'asset_subid' => 12],
        ['label' => 'Office Building', 'asset_id' => 1, 'asset_subid' => 13],
    ];

    foreach ($assets as $asset) {
        $asset_id = $asset['asset_id'];
        $asset_subid = isset($asset['asset_subid']) ? "AND asset_subid = {$asset['asset_subid']}" : '';
        $label = $asset['label'];

        $sql = "SELECT COUNT(*) as total 
                FROM depedldn_ams.asset a 
                INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer 
                WHERE a.asset_id = $asset_id $asset_subid";

        $result = $fconn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $data['labels'][] = $label;
            $data['values'][] = $row['total'];
        }
    }

    return $data;
}


function fetchData1($selectedOfficeId) {
    global $fconn;
    $data = ['labels' => [], 'values' => []];

    $assets = [
        ['label' => 'School Building', 'asset_id' => 1, 'asset_subid' => 1],
        ['label' => 'Other Structures', 'asset_id' => 1, 'asset_subid' => 2],
        ['label' => 'Machinery', 'asset_id' => 2, 'asset_subid' => 3],
        ['label' => 'Office Equipment', 'asset_id' => 2, 'asset_subid' => 4],
        ['label' => 'ICT Equipment', 'asset_id' => 2, 'asset_subid' => 5],
        ['label' => 'Agricultural & Forestry Equipment', 'asset_id' => 2, 'asset_subid' => 6],
        ['label' => 'Sports Equipment', 'asset_id' => 2, 'asset_subid' => 7],
        ['label' => 'Technical & Scientific Equipment', 'asset_id' => 2, 'asset_subid' => 8],
        ['label' => 'Motor Vehicle', 'asset_id' => 3, 'asset_subid' => 9],
        ['label' => 'Furnitures and Fixtures', 'asset_id' => 4, 'asset_subid' => 10],
        ['label' => 'Books', 'asset_id' => 4, 'asset_subid' => 11],
        ['label' => 'Other Property Plant and Equipment', 'asset_id' => 5, 'asset_subid' => 12],
        ['label' => 'Office Building', 'asset_id' => 1, 'asset_subid' => 13],
        ['label' => 'Land', 'asset_id' => 6],
    ];

    foreach ($assets as $asset) {
        $asset_id = $asset['asset_id'];
        $label = $asset['label'];

        if (isset($asset['asset_subid'])) {
            $asset_subid = $asset['asset_subid'];
            $stmt = $fconn->prepare("SELECT COUNT(*) as total 
                                     FROM depedldn_ams.asset 
                                     WHERE asset_id = ? AND asset_subid = ? AND user_id = ?");
            $stmt->bind_param("iii", $asset_id, $asset_subid, $selectedOfficeId);
        } else {
            $stmt = $fconn->prepare("SELECT COUNT(*) as total 
                                     FROM depedldn_ams.asset 
                                     WHERE asset_id = ? AND user_id = ?");
            $stmt->bind_param("ii", $asset_id, $selectedOfficeId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $data['labels'][] = $label;
            $data['values'][] = $row['total'];
        }
        $stmt->close();
    }

    return $data;
}

// Determine which chart data to fetch
if (isset($_POST['selectedOfficeId']) && !empty($_POST['selectedOfficeId'])) {
    $selectedOfficeId = intval($_POST['selectedOfficeId']);
    $data = fetchData1($selectedOfficeId);
} else {
    $data = fetchData();
}

// Output JSON response
echo json_encode($data);
?>
