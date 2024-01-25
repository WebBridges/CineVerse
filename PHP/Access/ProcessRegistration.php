<?php
    require_once("../db/AccessDB.php");

    if(insertNewAccount()){
        header("Location: ../2FAConfiguration.html");
    } else{
        http_response_code(400); // Bad Request
        echo "There was an error inserting the new account. Please try again.";
    }
?>