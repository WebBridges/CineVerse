<?php
    use Utente\UserUtility;
    require_once '../Utils/bootstrap.php';
    require_once("../Utils/user.php");

    sec_session_start();
    header('Content-Type: application/json');
    $user = UserUtility::retrieve_email($_SESSION['username']);
    echo json_encode(array("email" => $user));
?>