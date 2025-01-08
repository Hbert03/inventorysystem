<?php
session_start();
include('../../config/config_path.php');
include('../../config/fdatabase.php');

//data2.php
function getDataTable($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=4";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=4";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['list'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable($draw, $start, $length, $search, $fconn);
    exit();
}


if (isset($_POST['getdata'])) {
    $id = $_POST['id'];
    $query = "SELECT a.*, c.category, c.id as asset_id, sub.id, sub.sub_category, e.hris_code, CONCAT(e.firstname,' ', e.middlename, ' ', e.lastname) as fullname FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON a.account_officer = e.hris_code
    INNER JOIN category c ON a.asset_id = c.id INNER JOIN sub_category sub ON a.asset_subid = sub.id WHERE a.id=?";
    $stmt = $fconn->prepare($query);
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo "Error executing query: " . $fconn->error;
    }
    exit();
}

//data1.php
function getDataTable1($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=6";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count  FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer  WHERE a.asset_id = 2 AND a.asset_subid=6";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['list1'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable1($draw, $start, $length, $search, $fconn);
    exit();
}

//data2.php
function getDataTable2($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=5";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer  WHERE a.asset_id = 2 AND a.asset_subid=5";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['list2'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable2($draw, $start, $length, $search, $fconn);
    exit();
}


//data3.php
function getDataTable3($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=3";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=3";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['list3'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable3($draw, $start, $length, $search, $fconn);
    exit();
}


//data4.php
function getDataTable4($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE WHERE a.asset_id = 2 AND a.asset_subid=7";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count  FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=7";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['list4'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable4($draw, $start, $length, $search, $fconn);
    exit();
}


//data5.php

function getDataTable5($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=8";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=8";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['list5'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable5($draw, $start, $length, $search, $fconn);
    exit();
}

//land.php
function getDataTable6($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT * FROM depedldn_ams.asset WHERE asset_id = 6";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset WHERE asset_id = 6";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['land'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable6($draw, $start, $length, $search, $fconn);
    exit();
}

//build1.php
function getDataTable7($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=13";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=13";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['build1'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable7($draw, $start, $length, $search, $fconn);
    exit();
}


//build2.php
function getDataTable8($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=1";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=1";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['build2'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable8($draw, $start, $length, $search, $fconn);
    exit();
}

//build3.php
function getDataTable9($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=2";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=2";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['build3'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable9($draw, $start, $length, $search, $fconn);
    exit();
} 

//rpcppe.php
if (isset($_POST['rpcsp'])) {
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $category = $_POST["category"]; 

    echo getDataTable10($draw, $start, $length, $search, $fconn, $category, $_POST['value_range']);
    exit();
}

function getDataTable10($draw, $start, $length, $search, $fconn, $category, $value_range)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id  WHERE 1=1";
    if (!empty($category)) {
        $baseQuery .= " AND a.asset_subid = $category"; 
    }
    if ($value_range == 'below_5000') {
        $baseQuery .= " AND a.unit_val < 5000";
    } elseif ($value_range == 'above_5000') {
        $baseQuery .= " AND a.unit_val >= 5000";
    }
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE 1=1";
    if (!empty($category)) {
        $totalRecordsQuery .= " AND a.asset_subid = $category";
    }
    if ($value_range == 'below_5000') {
        $totalRecordsQuery .= " AND unit_val < 5000";
    } elseif ($value_range == 'above_5000') {
        $totalRecordsQuery .= " AND a.unit_val >= 5000";
    }
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}



if (isset($_POST['rpcppe'])) {
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $category = $_POST["category"]; 

    echo getDataTable11($draw, $start, $length, $search, $fconn, $category);
    exit();
}

function getDataTable11($draw, $start, $length, $search, $fconn, $category)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.unit_val > 49999";
    if (!empty($category)) {
        $baseQuery .= " AND a.asset_subid = $category"; 
    }
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.unit_val > 49999";
    if (!empty($category)) {
        $totalRecordsQuery .= " AND a.asset_subid = $category";
    }
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}

//transport.php
function getDataTable12($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 3 AND a.asset_subid=9";
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 3 AND a.asset_subid=9";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['transport'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable12($draw, $start, $length, $search, $fconn);
    exit();
} 

//book.php
function getDataTable13($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 4 AND a.asset_subid=11";
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 4 AND a.asset_subid=11";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['books'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable13($draw, $start, $length, $search, $fconn);
    exit();
} 

//furniture.php
function getDataTable14($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 4 AND a.asset_subid=10";
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 4 AND a.asset_subid=10";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['furniture'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable14($draw, $start, $length, $search, $fconn);
    exit();
} 
//others.php
function getDataTable15($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id  WHERE a.asset_id = 5 AND a.asset_subid=12";
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 5 AND a.asset_subid=12";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['others'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable15($draw, $start, $length, $search, $fconn);
    exit();
} 


function getDataTable16($draw, $start, $length, $search, $fconn)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=15";
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=15";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['historical'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable16($draw, $start, $length, $search, $fconn);
    exit();
} 




function getDataTable17($draw, $start, $length, $search, $fconn, $selectedOffice)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'date_t';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.user_id = '$selectedOffice'";
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    if (!empty($selectedOffice)) {
        $baseQuery .= " AND a.user_id = $selectedOffice"; 
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE  user_id = '$selectedOffice'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    if (!empty($selectedOffice)) {
        $selectedOffice .= " AND a.user_id = $selectedOffice"; 
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['ao_user_data'])) {   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $selectedOffice = $_POST["selectedOfficeId"];
    
    

    echo getDataTable17($draw, $start, $length, $search, $fconn, $selectedOffice);
    exit();
} 


function showAOLand($draw, $start, $length, $search, $fconn, $selectedOffice)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'date_t';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT * FROM asset WHERE user_id = '$selectedOffice' and asset_id=6";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    if (!empty($selectedOffice)) {
        $baseQuery .= " AND user_id = $selectedOffice"; 
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM asset WHERE user_id = '$selectedOffice' and asset_id=6";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    if (!empty($selectedOffice)) {
        $selectedOffice .= " AND user_id = $selectedOffice"; 
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['ao_land'])) {   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $selectedOffice = $_POST["selectedOfficeId"];
    
    

    echo showAOLand($draw, $start, $length, $search, $fconn, $selectedOffice);
    exit();
} 



if (isset($_POST['getdata_ao'])) {
    $id = $_POST['id'];
    $query = "SELECT a.*, c.category, c.id as asset_id, sub.id, sub.sub_category, e.hris_code, CONCAT(e.firstname,' ', e.middlename, ' ', e.lastname) as fullname FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON a.account_officer = e.hris_code
    INNER JOIN category c ON a.asset_id = c.id INNER JOIN sub_category sub ON a.asset_subid = sub.id WHERE a.id=?";
    $stmt = $fconn->prepare($query);
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo "Error executing query: " . $fconn->error;
    }
    exit();
}




if (isset($_POST['rpcppe_ao'])) {
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $category = $_POST["category"]; 
    $selectedOffice = $_POST["selectedOfficeId"];

    echo getDataTable18($draw, $start, $length, $search, $fconn, $category, $selectedOffice);
    exit();
}

function getDataTable18($draw, $start, $length, $search, $fconn, $category, $selectedOffice)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.unit_val > 49999 and a.user_id='$selectedOffice'";
    if (!empty($category)) {
        $baseQuery .= " AND a.asset_subid = $category"; 
    }
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.unit_val > 49999  and a.user_id='$selectedOffice'";
    if (!empty($category)) {
        $totalRecordsQuery .= " AND a.asset_subid = $category";
    }
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );
    return json_encode($output);
}
  


function getDataTable19($draw, $start, $length, $search, $fconn, $category, $value_range, $selectedOffice)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.user_id ='$selectedOffice' AND a.asset_id != 1";
    if (!empty($category)) {
        $baseQuery .= " AND a.asset_subid = $category"; 
    }
    if ($value_range == 'below_5000') {
        $baseQuery .= " AND a.unit_val < 5000";
    } elseif ($value_range == 'above_5000') {
        $baseQuery .= " AND a.unit_val >= 5000";
    }
    if (!empty($search)) {
        $baseQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.user_id ='$selectedOffice'";
    if (!empty($category)) {
        $totalRecordsQuery .= " AND a.asset_subid = $category";
    }
    if ($value_range == 'below_5000') {
        $totalRecordsQuery .= " AND unit_val < 5000";
    } elseif ($value_range == 'above_5000') {
        $totalRecordsQuery .= " AND a.unit_val >= 5000";
    }
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (a.asset_id LIKE '%$search%' OR description LIKE '%$search%' OR a.property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}



if (isset($_POST['rpcsp_ao'])) {
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $category = $_POST["category"]; 
    $selectedOffice = $_POST["selectedOfficeId"];

    echo getDataTable19($draw, $start, $length, $search, $fconn, $category, $_POST['value_range'], $selectedOffice);
    exit();
}

function Landsch($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT * FROM depedldn_ams.asset WHERE asset_id = 6 and user_id = '$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset WHERE asset_id = 6 and user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['land_sch'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = intval($_SESSION['user_id_sch']);


    echo Landsch($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}




function schoolbuilding($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=1 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=1 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['school_building'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo schoolbuilding($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}


function officebuilding($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=13 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=13 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['office_building'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo officebuilding($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}





function others_structure($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=2 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=2 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['others_structure'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo others_structure($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}




function historical_building($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 1 AND a.asset_subid=15 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 1 AND a.asset_subid=15 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['historical_building'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo historical_building($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}


function a_f_equipment($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=6 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=6 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['agircultural_equipment'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo a_f_equipment($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}







function machinery($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=3 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=3 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['machinery'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo machinery($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}



function office_equipment($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=4 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=4 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['office_equipment'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo office_equipment($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}


function sports_equipment($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=7 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=7 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['sports_equipment'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo sports_equipment($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}




function technical_equipment($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 2 AND a.asset_subid=8 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 2 AND a.asset_subid=8 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['technical_equipment'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo technical_equipment($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}



function transportation($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 3 AND a.asset_subid=9 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 3 AND a.asset_subid=9 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['transportation'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo transportation($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}


function books($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 4 AND a.asset_subid=11 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 4 AND a.asset_subid=11 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['books1'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo books($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}


function furniture1($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 4 AND a.asset_subid=10 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 4 AND a.asset_subid=10 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['furniture1'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo furniture1($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}


function others1($draw, $start, $length, $search, $fconn, $school_id)
{
    $sortableColumns = array('asset_id', 'description', 'property_no');

    $orderBy = 'description';
    $orderDir = 'DESC';

    if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
        $columnIdx = intval($_POST['order'][0]['column']);
        $orderDir = $_POST['order'][0]['dir'];

        if (isset($sortableColumns[$columnIdx])) {
            $orderBy = $sortableColumns[$columnIdx];
        }
    }

    $baseQuery = "SELECT a.*, CONCAT(e.firstname, ' ', COALESCE(SUBSTRING(e.middlename, 1, 1), ''), '. ', e.lastname, ' ', e.ext_name, ' - (', o.office_name, ')') AS fullname FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer INNER JOIN depedldn.tbl_office o ON e.department_id = o.id WHERE a.asset_id = 4 AND a.asset_subid=10 and a.user_id='$school_id'";
    if (!empty($search)) {
        $baseQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }

    $totalRecordsQuery = "SELECT COUNT(*) as count FROM depedldn_ams.asset a INNER JOIN
    depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id = 4 AND a.asset_subid=10 and a.user_id='$school_id'";
    if (!empty($search)) {
        $totalRecordsQuery .= " AND (asset_id LIKE '%$search%' OR description LIKE '%$search%' OR property_no LIKE '%$search%')";
    }
    $totalRecordsResult = $fconn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];

  
    $query = "$baseQuery ORDER BY $orderBy $orderDir LIMIT $start, $length";

    $result = $fconn->query($query);

    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $totalRecords = 0;
        $data = array();
        echo "Error executing query: " . $fconn->error;
    }

    $output = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords), 
        "recordsFiltered" => intval($totalRecords), 
        "data" => $data
    );

    return json_encode($output);
}
if (isset($_POST['others1'])) {
   
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];
    $school_id = $_SESSION['user_id_sch'];

    echo others1($draw, $start, $length, $search, $fconn, $school_id);
    exit();
}
?>


