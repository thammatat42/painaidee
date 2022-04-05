<?php 
    require_once '../../service/connect.php' ; 
    if( !isset($_SESSION['type'] ) ){
        header('Location: ../../pages/dashboard/'); 
    } 
?>