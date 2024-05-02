<?php
require_once("../Database/AccessDB.php");

sec_session_start();
if(checkAuthTfa($_POST['2fa'])=="false"){
    http_response_code(400); // Bad Request
    echo "There was an error during validation of account. Please try again.";
} else{
        
        unset($_SESSION['token']);
        header("location: ../../HTML/Profile/userpage.php");
    }
?>