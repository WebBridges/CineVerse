<?php
    require_once("../Database/AccessDB.php");
    if(check2fa($POST['code']) == "true"){
        echo Active2FA();
    } else{
        http_response_code(400); // Bad Request
        echo "There was an error during validation of account. Please try again.";
    }
?>