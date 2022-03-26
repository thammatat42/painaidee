<?php
require_once '../connect_mssql.php';

if(isset($_GET['location'])) {
    $LOCATION = $_GET['location'];

    $stmt_check_location = $connect->prepare("SELECT COUNT(*) AS CHECK_COUNT FROM TB_SPACE_LOCATION_UPDATE_FLG WHERE UPDATE_FLAG = 0 AND STATUS_CHG = 0 AND LOCATION = :LOCATION");
    $stmt_check_location->bindParam(':LOCATION', $LOCATION);
    $stmt_check_location->execute();
    $result_check_location = $stmt_check_location->fetch(PDO::FETCH_OBJ);
    
    if($result_check_location) {
        $CHECK_COUNT = $result_check_location->CHECK_COUNT;

        if($CHECK_COUNT > 0) {

            //Update..
            $stmt_update_location = $connect->prepare("UPDATE TB_SPACE_LOCATION_UPDATE_FLG SET UPDATE_FLAG = 1, UPDATE_DATE = '".date("Y-m-d H:i:s")."' WHERE STATUS_CHG = 0 AND LOCATION = :LOCATION");
            $stmt_update_location->bindParam(':LOCATION', $LOCATION);
            $CHECK_UPDATE = $stmt_update_location->execute();

            echo '<script>window.location.href = "../../pages/dashboard"</script>';

        } else {

            //Check Flag..
            $stmt_check_location = $connect->prepare("SELECT COUNT(*) AS CHECK_FLAG FROM TB_SPACE_LOCATION_UPDATE_FLG WHERE UPDATE_FLAG = 1 AND STATUS_CHG = 0 AND LOCATION = :LOCATION");
            $stmt_check_location->bindParam(':LOCATION', $LOCATION);
            $stmt_check_location->execute();
            $result_check_location = $stmt_check_location->fetch(PDO::FETCH_OBJ);

            if($result_check_location) {
                $CHECK_FLAG = $result_check_location->CHECK_FLAG;

                if($CHECK_FLAG > 0) {

                    //Update flag to 0..
                    $stmt_update_location = $connect->prepare("UPDATE TB_SPACE_LOCATION_UPDATE_FLG SET UPDATE_FLAG = 0, UPDATE_DATE = '".date("Y-m-d H:i:s")."' WHERE STATUS_CHG = 0 AND LOCATION = :LOCATION");
                    $stmt_update_location->bindParam(':LOCATION', $LOCATION);
                    $CHECK_UPDATE = $stmt_update_location->execute();

                    echo '<script>window.location.href = "../../pages/dashboard"</script>';
                } else {
                    //Insert..
                    $stmt_insert_location = $connect->prepare("INSERT INTO TB_SPACE_LOCATION_UPDATE_FLG (LOCATION, CREATE_DATE, UPDATE_FLAG, STATUS_CHG) VALUES (:LOCATION, '".date("Y-m-d H:i:s")."', 0, 0)");
                    $stmt_insert_location->bindParam(':LOCATION', $LOCATION);
                    $CHECK_INSERT = $stmt_insert_location->execute();

                    echo '<script>window.location.href = "../../pages/dashboard"</script>';
                }
            }
    
            
        }

    } 
    
}




?>