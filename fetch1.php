<?php
session_start();
include('../../config/config_path.php');
include('../../config/fdatabase.php');




// Fetch selected category
if(isset($_POST['asset1'])) {
    $query = "SELECT * FROM category WHERE id != '6'";
    $result = $fconn->query($query);
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
    echo json_encode($response);
}


if(isset($_POST['asset2'])) {
    $category_id = $_POST['category_id']; 
    $query = "SELECT * FROM sub_category WHERE category_fk = '$category_id'";
    $result = $fconn->query($query);
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
    echo json_encode($response);
}

if(isset($_POST['land'])) {
    $query = "SELECT * FROM category WHERE id ='6' ";
    $result = $fconn->query($query);
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
    echo json_encode($response);
}



if(isset($_POST['category'])){
    $query = "SELECT * FROM sub_category";
    $result = $fconn->query($query);
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
    echo json_encode($response);
}


// class FetchData {
//     private $fconn;

//     public function __construct($fconn) {
//         $this->fconn = $fconn;
//     }

//     public function fetchCategories() {
//         $query = "SELECT * FROM category";
//         $result = $this->fconn->query($query);
//         $response = [];
//         while ($row = $result->fetch_assoc()) {
//             $response['data'][] = $row;
//         }
//         return $response;
//     }

//     public function fetchSubCategories($categoryId) {
//         $query = "SELECT * FROM sub_category WHERE category_fk = ?";
//         $stmt = $this->fconn->prepare($query);
//         $stmt->bind_param("i", $categoryId);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $response = [];
//         while ($row = $result->fetch_assoc()) {
//             $response['data'][] = $row;
//         }
//         return $response;
//     }
// }

// if (isset($_POST['fetch1'])) {
//     $fetchData = new FetchData($fconn);
//     echo json_encode($fetchData->fetchCategories());
// }

// if (isset($_POST['fetch2'])) {
//     $categoryId = $_POST['category_id'];
//     $fetchData = new FetchData($fconn);
//     echo json_encode($fetchData->fetchSubCategories($categoryId));
// }

if (isset($_POST['select_Schools'])) {

    $school_handles = explode(',', $_SESSION['office_handle']);

  
    if (is_array($school_handles) && count($school_handles) > 0) {
        $school_ids = implode(',', array_map('intval', $school_handles)); 
        $query = "SELECT id, office_id, office_name FROM tbl_office WHERE id IN ($school_ids)";
    } else {
   
        $school_id = intval($school_handles); 
        $query = "SELECT id, office_id, office_name FROM tbl_office WHERE id = '$school_id'";
    }


    $school = (isset($_POST['term']) && !empty($_POST['term'])) ? $_POST['term'] : null;

    if ($school) {
        $query .= " AND office_name LIKE ?";
    } else {
        $query .= " LIMIT 10";
    }

    $stmt = $fconn2->prepare($query);

    if ($school) {
        $like_school = "%" . $school . "%";
        $stmt->bind_param("s", $like_school);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $district = array();

    while ($row = $result->fetch_assoc()) {
        $district[] = $row;
    }

    $stmt->close();
    $fconn2->close(); 


    echo json_encode(['results' => $district]);
}




if (isset($_POST['accountable_Employee'])) {
    $query = "SELECT hris_code, CONCAT(firstname, ' ', middlename, ' ', lastname) as employee FROM tbl_employee WHERE active = 1";

    $terms = (isset($_POST['term']) && !empty($_POST['term'])) ? $_POST['term'] : null;

    if ($terms) {
        $query .= " AND (firstname LIKE ? OR middlename LIKE ? OR lastname LIKE ?)";
    } else {
        $query .= " LIMIT 10";
    }

 
    $stmt = $fconn2->prepare($query);

    if ($terms) {
        $likeTerm = "%$terms%";
        $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $employees = array();

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    $stmt->close();
    $fconn2->close();

    echo json_encode(['result' => $employees]); 
}

if(isset($_POST['packages'])){
    $query = "SELECT * FROM package_type WHERE 1=1";
    $result = $fconn->query($query);
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
    echo json_encode($response);
}



if (isset($_POST['accountable_personnel'])) {
    $selected_officeID = $_POST['selectedOfficeId'];
    $query = "SELECT hris_code, CONCAT(firstname, ' ', middlename, ' ', lastname) as employee FROM tbl_employee WHERE active = 1";

    $terms = (isset($_POST['term']) && !empty($_POST['term'])) ? $_POST['term'] : null;

    if ($terms) {
        $query .= " AND (firstname LIKE ? OR middlename LIKE ? OR lastname LIKE ?)";
    } else {
        $query .= " LIMIT 10";
    }

 
    $stmt = $fconn2->prepare($query);

    if ($terms) {
        $likeTerm = "%$terms%";
        $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $employees = array();

    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }

    $stmt->close();
    $fconn2->close();

    echo json_encode(['results' => $employees]); 
}

if(isset($_POST['packages'])){
    $query = "SELECT * FROM package_type WHERE 1=1";
    $result = $fconn->query($query);
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
    echo json_encode($response);
}



if (isset($_GET['se_price'])) {
    $selectedSubCategoryId = $_GET['sub_category_id']; 

    $query = "SELECT price FROM se_price WHERE id_sub = ?";
    $stmt = $fconn->prepare($query);
    $stmt->bind_param("s", $selectedSubCategoryId);
    $stmt->execute();

    $result = $stmt->get_result();
    $response = ['data' => []];

    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }

    echo json_encode($response);
}


if(isset($_POST['supplier'])){
    $query = "SELECT * FROM supplier WHERE 1=1";
    $result = $fconn->query($query);
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response['data'][] = $row;
    }
    echo json_encode($response);
}
?>





