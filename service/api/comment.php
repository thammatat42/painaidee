<?php
    header('Content-Type: application/json');
    require_once '../connect.php';

    if(isset($_POST['btn_message'])) {
        $NAME = $_POST['name'];
        $EMAIL = $_POST['email'];
        $MESSAGE = $_POST['message'];
        $EMAIL_HIDDEN = $_POST['email_hidden'];
        $timer = date("Y-m-d H:i:s");
        $status_chg = 0;

        $stmt_user = $connect->prepare("SELECT * FROM tb_user WHERE EMAIL = :EMAIL AND STATUS_CHG = 0");
        $stmt_user->bindParam(':EMAIL', $EMAIL);
        $stmt_user->execute();
        $result_user = $stmt_user->fetch(PDO::FETCH_OBJ);

        if($result_user) {
            $IMG = $result_user->IMG;
        } else {
            $IMG = 'guest.png';
        }

        $sql = "INSERT INTO tb_comment (NAME,EMAIL,IMG, MESSAGE, OWNER, COMMENT_BY, COMMENT_DATE, STATUS_CHG)
                VALUES (:NAME, :EMAIL, :IMG, :MESSAGE, :OWNER, :COMMENT_BY, :COMMENT_DATE, :STATUS_CHG)";
        $stmt= $connect->prepare($sql);
        $stmt->bindParam(':NAME', $NAME);
        $stmt->bindParam(':EMAIL', $EMAIL);
        $stmt->bindParam(':IMG', $IMG);
        $stmt->bindParam(':MESSAGE', $MESSAGE);
        $stmt->bindParam(':OWNER', $EMAIL_HIDDEN);
        $stmt->bindParam(':COMMENT_BY', $EMAIL);
        $stmt->bindParam(':COMMENT_DATE', $timer);
        $stmt->bindParam(':STATUS_CHG', $status_chg);
        $INSERT_COMMENT = $stmt->execute();

        if($INSERT_COMMENT) {
            http_response_code(200);
            echo json_encode(array('status' => 'success', 'message' => 'ว้าวว!! ขอบคุณที่เเสดงความคิดเห็นกับเรา <3'));
        } else {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ไม่สามารถเเสดงความคิดเห็นได้..โปรดเเจ้งทีม support!'));
        }

    }
    
?>