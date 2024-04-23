<?php
    include_once(__DIR__ . "/bootstrap.php");
    include_once(__DIR__ . "/../Database/AccessDB.php");
    sec_session_start();

    if(!isset($_COOKIE['token'])) {
        header('Location: ../../HTML/Access/LoginPage.php');
        exit;
    } 
    try {
        $username = retrieveUsername_from_token($_COOKIE["token"]);
        $_SESSION['username'] = $username;
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(array("error" => "Invalid token"));
        header('Location: ../../HTML/Access/LoginPage.php');
        exit();
    }
?>