<?php
session_start();

if (!defined('DB_PATH')) {
    define('DB_PATH', '../../config/');
    include $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
}


        if (isset($_POST['loginbut'])) {
            $username = $_POST['uname'];
            $password = md5($_POST['password']); 

            loginUser($username, $password);
        }

        function loginUser($username, $password)
        {
            global $fconn2;

            $stmt = $fconn2->prepare("SELECT tbl_user.*, tbl_office.office_name 
            FROM tbl_user 
            JOIN tbl_office ON tbl_office.office_id = tbl_user.department 
            WHERE tbl_user.username = ? AND tbl_user.password = ?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $userRow = $userResult->fetch_assoc();

        $custom_office = array('352', '340'); 

        if (!empty($userRow)) {
        $tmp_user_id = $userRow['user_id'];
        $tmp_user_school = $userRow['office_name'];

        if (in_array($tmp_user_id, $custom_office)) {

        $_SESSION['personnel'] = $tmp_user_id;
        $_SESSION['school'] = $tmp_user_school;
        header("Location: invent_home.php");
        exit();
        } else {
            $_SESSION['personnel'] = $tmp_user_id;
            $_SESSION['school'] = $tmp_user_school;
            $_SESSION['user_id_sch'] = $tmp_user_id;
            header("Location: school/invent_school.php");
   
        exit();
        }
        } else {
        $aoStmt = $fconn2->prepare("SELECT ao_user.*, ao_office.office_id, CONCAT(e.firstname, ' ', e.lastname) AS employee_name 
            FROM tbl_district_office_user ao_user
            INNER JOIN tbl_ao_office ao_office ON ao_user.id = ao_office.ao_user
            INNER JOIN tbl_employee e ON e.hris_code = ao_user.hris
            WHERE ao_user.useraccount = ? AND ao_user.password = ?");

        $aoStmt->bind_param('ss', $username, $password);
        $aoStmt->execute();
        $aoResult = $aoStmt->get_result();
        $aoRow = $aoResult->fetch_assoc();
    
        if (!empty($aoRow)) {
            $_SESSION['employee_name'] = $aoRow['employee_name']  ; 
            $_SESSION['office_handle'] = $aoRow['district']; 
            $_SESSION['user_id'] = $aoRow['id']; 
            $_SESSION['account_id'] = $aoRow['id']; 
            $_SESSION['office_id'] = $aoRow['office_id']; 
            header("Location: invent_index.php");
            exit();
        } else {
            $_SESSION['login'] = "Wrong Username and Password!";
            $_SESSION['login_code'] = "error";
            header("Location: index.php");
            exit();
        }
    }
    
    
        }
        ?>
