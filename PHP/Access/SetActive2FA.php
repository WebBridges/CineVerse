<?php
    require_once("../Bootstrap.php");
    if(check2FA($POST['code']) == "true"){
        echo $db->Active2FA();
    } else{
        http_response_code(400); // Bad Request
        echo "There was an error during validation of account. Please try again.";
    }
?>