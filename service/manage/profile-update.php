<?php
header('Content-Type: application/json');
require_once '../connect.php';

if(isset($_POST['btn_profile'])) {
    $NAME = $_POST['name'];
    $EMAIL = $_POST['email'];
    $ABOUT_ME = $_POST['about_me'];

    $timer = date("Y-m-d H:i:s");
    //เปลี่ยนชื่อรูปภาพกรณีมีการ upload ไว้ตรวจสอบ
    $t = microtime(true);
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $datetime = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

    if($_FILES){
        $CHG_FILES = explode(".",$_FILES["newProfilePhoto"]["name"]);
        $CHG_FILES = $datetime->format("Ymdu").'.'.$CHG_FILES[1];
        $target_dir = "../../assets/upload/";
        $target_file = $target_dir . basename($CHG_FILES);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // เช็คไฟล์เกิน 5 mb หรือไม่
        if ($_FILES["newProfilePhoto"]["size"] > 5000000) {
            $uploadOk = 0;
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: ไฟล์รูปภาพของคุณมีขนาดใหญ่เกินต้องไม่เกิน 5MB..'));
        } 

        if ($uploadOk == 0) {
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: กรุณาอัพโหลดรูปภาพของคุณใหม่อีกครั้ง..'));
        } else {
            $stmt = $connect->prepare("SELECT count(*) as chk_count FROM tb_user WHERE EMAIL = :EMAIL AND STATUS_CHG = 0");
            $stmt->bindParam(':EMAIL', $EMAIL);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $result->chk_count;

            if($count > 0) {
                //เเก้ไขใช้รูปภาพใหม่
                if (move_uploaded_file($_FILES["newProfilePhoto"]["tmp_name"], $target_file)) {
                    $sql = "UPDATE tb_user
                    SET NAME = :NAME, IMG = :IMG, ABOUT_ME = :ABOUT_ME, UPDATE_BY = :UPDATE_BY, UPDATE_DATE = :UPDATE_DATE
                    WHERE EMAIL = :EMAIL AND STATUS_CHG = 0
                    ";  
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':NAME', $NAME);
                    $stmt->bindParam(':IMG', $CHG_FILES);
                    $stmt->bindParam(':ABOUT_ME', $ABOUT_ME);
                    $stmt->bindParam(':UPDATE_BY', $EMAIL);
                    $stmt->bindParam(':UPDATE_DATE', $timer);
                    $stmt->bindParam(':EMAIL', $EMAIL);
                    $UPDATE_PROFILE_WITH_IMG = $stmt->execute();

                    if($UPDATE_PROFILE_WITH_IMG) {
                        http_response_code(200);
                        echo json_encode(array('status' => true, 'message' => 'เเก้ไขข้อมูลเรียบร้อยแล้ว..'));
                    } else {
                        http_response_code(404);
                        echo json_encode(array('status' => false, 'message' => 'เกิดบางอย่างผิดปกติ..คิวรี่ผิดพลาดกรุณาเเจ้งทีม support..!'));
                    }
                    
                }
                    
            }
        }

    } else {
        //เเก้ไขโดยใช้รูปภาพเดิม
        $sql = "UPDATE tb_user
        SET NAME = :NAME, ABOUT_ME = :ABOUT_ME, UPDATE_BY = :UPDATE_BY, UPDATE_DATE = :UPDATE_DATE
        WHERE EMAIL = :EMAIL AND STATUS_CHG = 0
        ";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':NAME', $NAME);
        $stmt->bindParam(':ABOUT_ME', $ABOUT_ME);
        $stmt->bindParam(':UPDATE_BY', $EMAIL);
        $stmt->bindParam(':UPDATE_DATE', $timer);
        $stmt->bindParam(':EMAIL', $EMAIL);
        $UPDATE_PROFILE_WITHOUT_IMG = $stmt->execute();

        if($UPDATE_PROFILE_WITHOUT_IMG) {
            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'เเก้ไขข้อมูลเรียบร้อยแล้ว..'));
        } else {
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'เกิดบางอย่างผิดปกติ..คิวรี่ผิดพลาดกรุณาเเจ้งทีม support..!'));
        }
    }
}

?>
