<?php
    require_once("../Bootstrap.php");

    if($db->checkEmailExistence($_POST['email']) == "Email_available" ||
        $db->checkEmailExistence($_POST['email']) == "Email_invalid" ||
        $db->checkPassword($_POST['password'],$_POST['email']) == "Password_wrong" ||
        $db->checkPassword($_POST['password'],$_POST['email']) == "Password_invalid"){
            http_response_code(400); // Bad Request
            echo "There was an error during validation of account. Please try again.";
    } else{
        if($db->check2FA_Active()==true){
            header("location: ../2FA_Login.html");
        }
        else{header("Location: ../userpage.html");}
    }
?>