<?php
include ('../../config/fdatabase.php');
require ('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
header('Content-Type: application/json');

session_start(); 

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['asset']) && isset($input['rows'])) {
    $asset = $input['asset'];
    $rows = $input['rows'];

    $success = true;
    $errors = [];
    $insertedIds = [];

    foreach ($rows as $row) {
        $subCategory = $row[0];
        $price = isset($row[1]) ? $row[1] : null; 


        $query = "INSERT INTO sub_category (sub_category, category_fk) VALUES (?, ?)";
        $stmt = $fconn->prepare($query);
        $stmt->bind_param("si", $subCategory, $asset);

        if ($stmt->execute()) {

            $insertedId = $stmt->insert_id;
            $insertedIds[] = $insertedId;

            if ($price !== null) {
                $query2 = "INSERT INTO se_price (id_sub, price) VALUES (?, ?)";
                $stmt2 = $fconn->prepare($query2);
                $stmt2->bind_param("id", $insertedId, $price);

                if (!$stmt2->execute()) {
                    $success = false;
                    $errors[] = "Error inserting into another_table for sub_category ID $insertedId: " . $stmt2->error;
                }
            }
        } else {
            $success = false;
            $errors[] = "Error inserting into sub_category: " . $stmt->error;
        }
    }


    $_SESSION['inserted_ids'] = $insertedIds;

    if ($success) {
        echo json_encode(['success' => 1, 'inserted_ids' => $insertedIds]);
    } else {
        echo json_encode(['success' => 0, 'errors' => $errors]);
    }
} else {
    echo json_encode(['success' => 0, 'error' => 'Invalid input data.']);
}
?>
