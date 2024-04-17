<?php
    require_once("../Utils/user.php");
    use user\UserUtility;

    $us = $_GET['user'];
    $photo = UserUtility::retrieve_profile_photo($us);
    header('Content-Type: application/json');
    echo json_encode($photo, JSON_PRETTY_PRINT);
?>