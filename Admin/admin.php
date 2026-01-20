<?php

if(!isset($_SESSION)){
    session_start();
}
include_once('../dbConnection.php');

//Admin Login
if(isset($_POST['checkLogemail']) && isset($_POST['adminLogEmail']) && isset($_POST['adminLogPass'])){

    $adminLogEmail = $_POST['adminLogEmail'];
    $adminLogPass  = $_POST['adminLogPass'];

    // $sql = "SELECT * FROM admin WHERE admin_email='$adminLogEmail' AND admin_pass='$adminLogPass'";
    // $result = $conn->query($sql);

    $sql = "SELECT * FROM user WHERE user_email='$adminLogEmail'";
    $result = $conn->query($sql);
    if($result->num_rows == 1){

        $rows=$result->fetch_assoc();
        if($rows['role'] != 'admin'){
            echo json_encode(0);   // invalid
            exit();
        }
        if(password_verify($adminLogPass, $rows['user_pwd'])){
            $_SESSION['is_admin_login'] = true;
            $_SESSION['adminLogEmail'] = $adminLogEmail;
            $_SESSION['admin_name'] = "Shnider"; // SAVE NAME

            echo json_encode(1);   // success
        } 
        else {
            echo json_encode(0);   // invalid
        }
    }
}
?>