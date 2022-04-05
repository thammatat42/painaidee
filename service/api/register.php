<?php
    header('Content-Type: application/json');
    require_once '../connect.php';

    // echo '<pre>';
    // print_r($_POST);
    // die();
    
    //เช็คสิทธิ์ยอมรับกฏตามเงื่อนไข
    if(isset($_POST['agreeTerms']) == 1) {
        $_SESSION['fullname'] = $_POST['fullname'];
        $_SESSION['email'] = $_POST['email'];
        $FULLNAME = $_POST['fullname'];
        $EMAIL = $_POST['email'];
        $PASSWORD = md5($_POST['password']);
        $CONFIRM_PASSWORD = md5($_POST['confirm_password']);

        //เช็ค password ตรงกันไหม
        if($PASSWORD == $CONFIRM_PASSWORD) {

            //ถ้าตรงเช็คข้อมูลในระบบว่าเคยมีในระบบหรือยัง
            $stmt_check_user = $connect->prepare("SELECT COUNT(*) AS CHECK_COUNT FROM tb_user WHERE EMAIL = :EMAIL AND STATUS_CHG = 0");
            $stmt_check_user->bindParam(':EMAIL', $EMAIL);
            $stmt_check_user->execute();
            $result_check_user = $stmt_check_user->fetch(PDO::FETCH_OBJ);

            if($result_check_user) {
                $count_user = $result_check_user->CHECK_COUNT;

                //ถ้ามีเเล้วเเจ้ง alert ไปหา user
                if($count_user > 0) {
                    http_response_code(405);
                    echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: อีเมลนี้มีผู้ใช้งานแล้ว..'));
                } else {
                    //ถ้าไม่มีเก็บลง db
                    $stmt_insert = $connect->prepare("INSERT INTO tb_user (NAME, EMAIL, PASSWORD, IMG, TYPE, STATUS_LOGIN, CREATE_BY, CREATE_DATE, STATUS_CHG) VALUES (:NAME, :EMAIL, :PASSWORD, 'no_img.jpg', 'user', 'Active', :CREATE_BY, '".date("Y-m-d H:i:s")."', 0)");
                    $stmt_insert->bindParam(':NAME', $FULLNAME);
                    $stmt_insert->bindParam(':EMAIL', $EMAIL);
                    $stmt_insert->bindParam(':PASSWORD', $PASSWORD);
                    $stmt_insert->bindParam(':CREATE_BY', $EMAIL);
                    $CHECK_INSERT = $stmt_insert->execute();

                    if($CHECK_INSERT) {
                        http_response_code(200);
                        echo json_encode(array('status' => true, 'message' => 'สมัครสมาชิกสำเร็จ..'));
                    } else {
                        http_response_code(404);
                        echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: คิวรี่ข้อมูลมีปัญหา..กรุณาเเจ้งฝ่าย support!'));
                    }
                }
            }
                
        } else {
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: รหัสผ่านไม่ตรงกัน..'));
        }
    }
    
?>