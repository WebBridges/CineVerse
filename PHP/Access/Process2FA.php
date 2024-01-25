<?php
require_once("../db/AccessDB.php");

sec_session_start();
if(check2FA($_POST['2fa'])=="false"){
    http_response_code(400); // Bad Request
    echo "There was an error during validation of account. Please try again.";
} else{
    if(!check2FA_Active()){
        active2FA();
    }
    unset($_SESSION['code2FA']);
    header("location: ../userpage.html");
    }
?>