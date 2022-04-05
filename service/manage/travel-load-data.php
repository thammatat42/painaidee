<?php
header('Content-Type: application/json');
require_once '../connect.php';

$stmt = $connect->prepare("SELECT a.*,b.name_th as amphures ,c.name_th as provinces FROM `tb_travel` as a
INNER JOIN amphures as b on a.AMPHURES_ID = b.id
INNER JOIN provinces as c on a.PROVINCE_ID = c.id 
WHERE a.STATUS_CHG = 0");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(count($result) > 0) {
    $response = [
        'status' => true,
        'response' => $result,
        'message' => 'Get data success!'
    ];
    http_response_code(200);
    echo json_encode($response);
} else {
    $response = [
        'status' => true,
        'message' => 'error: No data!'
    ];
    http_response_code(404);
    echo json_encode($response);
}

?>