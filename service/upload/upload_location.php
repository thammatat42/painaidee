<?php
header('Content-Type: application/json');
require_once '../connect_mssql.php';
// require_once '../../service/db-config.php';
require("../../plugins/PHPExcel/Classes/PHPExcel/IOFactory.php");


if(isset($_POST['upload_location'])) {

    $fileName = "";

    // if there is any file
    if(isset($_FILES['customfile'])){

        // reading tmp_file name
        $fileName = $_FILES["customfile"]["tmp_name"];

        $count_column = 1;
        $column_name = array("LOCATION");
        
    }

    $counter = 0;	

    if (isset($_FILES["customfile"]) && $_FILES["customfile"]["size"] > 0) {   
        $file_array = explode(".", $_FILES["customfile"]["name"]);

        if ($file_array[1] == "xlsx" || $file_array[1] == "csv" || $file_array[2] == "xlsx" || $file_array[2] == "csv") {
            $object = PHPExcel_IOFactory::load($_FILES["customfile"]["tmp_name"]);
            
            $array_failed = [];
            $array_location = [];
            $adjust_location = 0;
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();

                $RowSkip = 2;

                for ($row = $RowSkip; $row <= $highestRow; $row++) {
                    for ($column_number = 0; $column_number < $count_column; $column_number++) {
                        $data_in_file = $worksheet->getCellByColumnAndRow($column_number, $row)->getValue();
                        $check_value_excel[$column_number] = $data_in_file;
                    }
    
                    $value_excel = array_combine($column_name, $check_value_excel);
    
                    $arr_value = ('\'' . implode('\',\'', array_values($value_excel)) . '\'');

                    $LOCATION = $value_excel['LOCATION'];


                    /* เช็ค mst location ว่าว่างไหม */
                    $stmt_check_location = $connect->prepare("SELECT COUNT(*) AS CHECK_LOCATION FROM TB_SPACE_LOCATION_UPDATE_FLG WHERE LOCATION = :LOCATION AND UPDATE_FLAG = 0 AND STATUS_CHG = 0");
                    $stmt_check_location->bindParam(':LOCATION', $LOCATION);
                    $stmt_check_location->execute();
                    $result_check_location = $stmt_check_location->fetch(PDO::FETCH_OBJ);
                    $CHECK_LOCATION = $result_check_location->CHECK_LOCATION;
                    

                    if($CHECK_LOCATION > 0) {
                        //รหัส code error inventory 101 = คลังสินค้าไม่พอ
                        $array_failed[] = $LOCATION;
                        $adjust_location = 101;

                    } else {
                        //เก็บค่าใส่ array เพื่อที่ไป update
                        $array_location[] = $LOCATION;
                    }

                    
                }
            }
            

            if($adjust_location == 101) { 
                http_response_code(404);
                echo json_encode(array('status' => false, 'message' => 'Something went wrong (Error code: 101): Location not avaliable: '.implode(',', $array_failed)));
            } else {
                $count_success = count($array_location);
                for($i=0; $i<$count_success; $i++) {

                    //Check Flag..
                    $stmt_check_location = $connect->prepare("SELECT COUNT(*) AS CHECK_FLAG FROM TB_SPACE_LOCATION_UPDATE_FLG WHERE UPDATE_FLAG = 1 AND STATUS_CHG = 0 AND LOCATION = :LOCATION");
                    $stmt_check_location->bindParam(':LOCATION', $array_location[$i]);
                    $stmt_check_location->execute();
                    $result_check_location = $stmt_check_location->fetch(PDO::FETCH_OBJ);

                    if($result_check_location) {
                        $CHECK_FLAG = $result_check_location->CHECK_FLAG;

                        if($CHECK_FLAG > 0) {

                            //Update flag to 0..
                            $stmt_update_location = $connect->prepare("UPDATE TB_SPACE_LOCATION_UPDATE_FLG SET UPDATE_FLAG = 0, UPDATE_DATE = '".date("Y-m-d H:i:s")."' WHERE STATUS_CHG = 0 AND LOCATION = :LOCATION");
                            $stmt_update_location->bindParam(':LOCATION', $array_location[$i]);
                            $CHECK_UPDATE = $stmt_update_location->execute();

                        } else {
                            //Insert..
                            $stmt_insert_location = $connect->prepare("INSERT INTO TB_SPACE_LOCATION_UPDATE_FLG (LOCATION, CREATE_DATE, UPDATE_FLAG, STATUS_CHG) VALUES (:LOCATION, '".date("Y-m-d H:i:s")."', 0, 0)");
                            $stmt_insert_location->bindParam(':LOCATION', $array_location[$i]);
                            $CHECK_INSERT = $stmt_insert_location->execute();
                        }
                    }

                }

                if(isset($CHECK_UPDATE) || isset($CHECK_INSERT)){
                    
                    http_response_code(200);
                    echo json_encode(array('status' => true, 'message' => 'Update location successfully..'));
                } else {
                    http_response_code(404);
                    echo json_encode(array('status' => false, 'message' => 'Something went wrong..Can not update location!!'));
                }
            }
            
        }
        
    }

}
?>