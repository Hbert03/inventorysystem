<?php 
session_start();

if(isset($_POST['confirm_logout'])) {
    // If user confirms logout
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
} else {
    header("Location: .php");
    exit();
}
?>
