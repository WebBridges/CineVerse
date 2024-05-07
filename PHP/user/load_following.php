<?php
    require_once("../Utils/user.php");
    use User\UserUtility;

    $username = $_GET['username'];
    $followed = UserUtility::retrieve_followed($username);
    header('Content-Type: application/json');
    echo json_encode($followed, JSON_PRETTY_PRINT);
?>