<?php
require_once("../Bootstrap.php");

if(check2FA($_POST['2fa'])=="false"){
    http_response_code(400); // Bad Request
    echo "There was an error during validation of account. Please try again.";
} else{
    if(!$db->check2FA_Active()){
        $db->active2FA();
    }
    unset($_SESSION['code2FA']);
    header("location: ../userpage.html");
    }
?>