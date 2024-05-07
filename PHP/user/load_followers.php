<?php
    require_once("../Utils/user.php");
    use User\UserUtility;

    $username = $_GET['username'];
    $followers = UserUtility::retrieve_followers($username);
    header('Content-Type: application/json');
    echo json_encode($followers, JSON_PRETTY_PRINT);
?>