<?php
/**
 */
header('Content-Type: application/json');
require_once '../connect.php';
require_once "../function/LDAP.func";
ini_set('display_errors','Off');


$username = $_POST['username'];
$password = $_POST['password'];
$remember_me = $_POST['remember'];



if($_SERVER['REQUEST_METHOD'] === "POST"){
    if (LDAP_LOGIN($username, $password, $connect)) {

        $NAME = $_SESSION['name'];
        $TYPE = $_SESSION['type'];
        
    
        http_response_code(200);
        echo json_encode(array('status' => true, 'message' => 'เข้าสู่ระบบสำเร็จ..'));
    }
    
} else {
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'วิธีการเข้าถึงไม่ถูกต้อง..'));
    // header("Location: ../../pages/includes/error-405.php");
    exit();
}