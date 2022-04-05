<?php
header('Content-Type: application/json');
require_once '../connect.php';


if(isset($_POST['submit'])) {
    $province = $_POST['province'];
    $city = $_POST['city'];
    $topic = $_POST['topic'];
    $about = $_POST['about'];
    $detail = $_POST['detail'];
    $timer = date("Y-m-d H:i:s");
    //เปลี่ยนชื่อรูปภาพกรณีมีการ upload ไว้ตรวจสอบ
    $t = microtime(true);
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $datetime = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

    if($_FILES){
        $CHG_FILES = explode(".",$_FILES["customfile"]["name"]);
        $CHG_FILES = $datetime->format("Ymdu").'.'.$CHG_FILES[1];
        $target_dir = "../../assets/upload/";
        $target_file = $target_dir . basename($CHG_FILES);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // เช็คไฟล์เกิน 5 mb หรือไม่
        if ($_FILES["customfile"]["size"] > 5000000) {
            $uploadOk = 0;
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: ไฟล์รูปภาพของคุณมีขนาดใหญ่เกินต้องไม่เกิน 5MB..'));
        } 

        //เช็คเงื่อนไขการ upload รูปภาพ
        if ($uploadOk == 0) {
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: กรุณาอัพโหลดรูปภาพของคุณใหม่อีกครั้ง..'));
        } else {
            $stmt = $connect->prepare("SELECT count(*) as chk_count FROM tb_travel WHERE AMPHURES_ID = :AMPHURES_ID");
            $stmt->bindParam(':AMPHURES_ID', $city);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $result->chk_count;

            if($count > 0) {
                //เเก้ไขใช้รูปภาพใหม่
                if (move_uploaded_file($_FILES["customfile"]["tmp_name"], $target_file)) {
                    $sql = "UPDATE tb_travel 
                            SET TOPIC = :TOPIC, ABOUT = :ABOUT, DETAIL = :DETAIL, UPDATE_BY = :UPDATE_BY, IMG = :IMG, UPDATE_DATE = :UPDATE_DATE, STATUS_CHG = 0
                            WHERE AMPHURES_ID = :AMPHURES_ID
                    ";  
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':TOPIC', $topic);
                    $stmt->bindParam(':ABOUT', $about);
                    $stmt->bindParam(':DETAIL', $detail);
                    $stmt->bindParam(':UPDATE_BY', $_SESSION['email']);
                    $stmt->bindParam(':IMG', $CHG_FILES);
                    $stmt->bindParam(':UPDATE_DATE', $timer);
                    $stmt->bindParam(':AMPHURES_ID', $city);
                    $UPDATE_TRAVEL_ATTACH_IMG = $stmt->execute();

                    if($UPDATE_TRAVEL_ATTACH_IMG) {
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
        $sql = "UPDATE tb_travel 
                SET TOPIC = :TOPIC, ABOUT = :ABOUT, DETAIL = :DETAIL, UPDATE_BY = :UPDATE_BY, UPDATE_DATE = :UPDATE_DATE, STATUS_CHG = 0
                WHERE AMPHURES_ID = :AMPHURES_ID
        ";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':TOPIC', $topic);
        $stmt->bindParam(':ABOUT', $about);
        $stmt->bindParam(':DETAIL', $detail);
        $stmt->bindParam(':UPDATE_BY', $_SESSION['email']);
        $stmt->bindParam(':UPDATE_DATE', $timer);
        $stmt->bindParam(':AMPHURES_ID', $city);
        $UPDATE_TRAVEL_NO_IMG = $stmt->execute();

        if($UPDATE_TRAVEL_NO_IMG) {
            http_response_code(200);
            echo json_encode(array('status' => true, 'message' => 'เเก้ไขข้อมูลเรียบร้อยแล้ว..'));
        } else {
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'เกิดบางอย่างผิดปกติ..คิวรี่ผิดพลาดกรุณาเเจ้งทีม support..!'));
        }
    }

}


?>