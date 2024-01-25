<?php
    require_once("../db/AccessDB.php");
    
    if(checkEmailExistence($_POST['email']) == "Email_available" ||
        checkEmailExistence($_POST['email']) == "Email_invalid" ||
        checkPassword($_POST['password'],$_POST['email']) == "Password_wrong" ||
        checkPassword($_POST['password'],$_POST['email']) == "Password_invalid"){
            http_response_code(400); // Bad Request
            echo "There was an error during validation of account. Please try again.";
    } else{
        if(check2FA_Active()==true){
            header("location: ../2FA_Login.html");
        }
        else{header("Location: ../userpage.html");}
    }
?>