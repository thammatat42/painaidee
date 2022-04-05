<?php
header('Content-Type: application/json');
require_once '../connect.php';

$ID = $_POST['id'];
$timer = date("Y-m-d H:i:s");
$status_chg = 1;

$sql = "UPDATE tb_travel SET UPDATE_BY = :UPDATE_BY, UPDATE_DATE = :UPDATE_DATE, STATUS_CHG = :STATUS_CHG
WHERE ID = :ID
";
$stmt = $connect->prepare($sql);
$stmt->bindParam(':UPDATE_BY', $_SESSION['email']);
$stmt->bindParam(':UPDATE_DATE', $timer);
$stmt->bindParam(':STATUS_CHG', $status_chg);
$stmt->bindParam(':ID', $ID);
$DELETE_TRAVEL = $stmt->execute();

if($DELETE_TRAVEL) {
    $response = [
        'status' => true,
        'message' => 'ลบข้อมูลเรียบร้อยเเล้ว..'
    ];
    http_response_code(200);
    echo json_encode($response);

} else {
    http_response_code(404);
    echo json_encode(array('status' => false, 'message' => 'เกิดข้อผิดพลาด: คิวรี่ผิดปกติ..โปรดติดทีม support..!'));
}


?>