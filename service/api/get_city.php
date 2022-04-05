<?php 
header('Content-Type: application/json');
require_once '../connect.php';


if(isset($_POST['function']) && $_POST['function'] == 'get_city') {
    $id = $_POST['id'];

    $stmt_amphures = $connect->prepare("SELECT * FROM amphures WHERE province_id = :province_id");
    $stmt_amphures->bindParam(':province_id', $id);
    $stmt_amphures->execute();
    $result_amphures = $stmt_amphures->fetchAll(PDO::FETCH_ASSOC);

    echo '<option disabled selected>กรุณาเลือกอำเภอ</option>';
    foreach($result_amphures as $key_amphures => $value_amphures) {
        echo '<option value="'.$value_amphures['id'].'">'.$value_amphures['name_th'].'</option>';
    }
    exit();
}


?>