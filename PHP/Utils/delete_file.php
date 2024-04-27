<?php
    require_once("./Images_utils.php");
    
    $file_name = $_GET['file_name'];
    delete_file($file_name);
?>