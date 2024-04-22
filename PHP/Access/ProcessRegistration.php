<?php
    require_once("../Database/AccessDB.php");

    if(insertNewAccount()){
        header("Location: ../../HTML/Access/2FAConfiguration.php");
    } else{
        http_response_code(400); // Bad Request
        echo "There was an error inserting the new account. Please try again.";

    }
?>