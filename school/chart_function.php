<?php
session_start();
include('../../../config/config_path.php');
include('../../../config/fdatabase.php');

header('Content-Type: application/json');

function fetchData() {
    if (isset($_SESSION['user_id_sch'])) {
        $school_id = intval($_SESSION['user_id_sch']);
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
                $stmt = $fconn->prepare("SELECT COUNT(*) as total FROM depedldn_ams.asset WHERE asset_id = ? AND asset_subid = ? AND user_id = ?");
                $stmt->bind_param("iii", $asset_id, $asset_subid, $school_id);
            } else {
                $stmt = $fconn->prepare("SELECT COUNT(*) as total FROM depedldn_ams.asset WHERE asset_id = ? AND user_id = ?");
                $stmt->bind_param("ii", $asset_id, $school_id);
            }

            try {
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $data['labels'][] = $label;
                    $data['values'][] = $row['total'];
                }
            } catch (Exception $e) {
            }

            $stmt->close();
        }
    }

    return $data;
}

echo json_encode(fetchData());
?>