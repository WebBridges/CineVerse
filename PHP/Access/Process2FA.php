<?php
require_once("../Database/AccessDB.php");

sec_session_start();
if(checkAuthTfa($_POST['2fa'])=="false"){
    http_response_code(400); // Bad Request
    echo "There was an error during validation of account. Please try again.";
} else{
        active2FA();
        unset($_SESSION['email']);
        unset($_SESSION['token']);
        unset($_SESSION['email']);
        header("location: ../../HTML/Access/LoginPage.php");
    }
?>