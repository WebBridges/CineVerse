<?php
    require_once("../Database/AccessDB.php");

    if(!isset($_COOKIE['token'])) {
        header('Location: ../../HTML/Access/LoginPage.html');
        exit;
    } 
    try {
        $username = retrieveUsername_from_token($_COOKIE["token"]);
        $_SESSION['username'] = $username;
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(array("error" => "Invalid token"));
        exit();
    }
?>