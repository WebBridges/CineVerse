<?php
    require_once '../Utils/bootstrap.php';
    sec_session_start();
    header('Content-Type: application/json');
    echo json_encode(array("username" => $_SESSION['username']));
?>