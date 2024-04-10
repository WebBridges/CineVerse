<?php
    require_once("../Database/AccessDB.php");
    require_once("bootstrap.php");
    sec_session_start();

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
        header('Location: ../../HTML/Access/LoginPage.html');
        exit();
    }
?>