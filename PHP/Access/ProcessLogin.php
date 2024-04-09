<?php
    require_once("../Database/AccessDB.php");

    if(checkEmailExistence($_POST['email']) == "Email_available" ||
        checkEmailExistence($_POST['email']) == "Email_invalid" ||
        !checkPassword($_POST['password'],$_POST['email']) == "Password_wrong" ||
        checkPassword($_POST['password'],$_POST['email']) == "Password_invalid"){
            http_response_code(400); // Bad Request
            echo "There was an error during validation of account. Please try again.";
    } else{
        processLogin($_POST['email']);
        if(check2FA_Active()==true){
            header("location: ../../HTML/Access/2FA_Login.html");
        }
        else{header("Location: ../../HTML/Profile/userpage.html");}
    }
?>