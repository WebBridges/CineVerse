<?php

function validateRegistrationInfo(){
        $regex = "/[^a-zA-Z ]/";
        $regexExtended = "/[^a-zA-Z0-9 _]/";
        $regexPassword = "/[^a-zA-Z0-9 _!@#$%^*]/";
        $date = DateTime::createFromFormat('d-m-Y', $_POST['birthDate']);
        $thirteenYearsAgo = (new DateTime())->modify('-13 years');

        if(!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['username']) || !isset($_POST['email']) ||
        !isset($_POST['password']) || !isset($_POST['confirmPassword']) || !isset($_POST['birthDate']) || 
        !isset($_POST['bio']) || !isset($_POST['profilePicture']) || !isset($_POST['topic'])){
            return false;
        }

        if(strlen($_POST['name'])>30 || strlen($_POST['surname'])>30 || strlen($_POST['username'])>30 ||
            strlen($_POST['email'])>50 || (!empty($_POST['recoveryEmail']) && strlen($_POST['recoveryEmail'])>50) || strlen($_POST['password'])>30 || 
            strlen($_POST['password'])<8 || strlen($_POST['confirmPassword'])>30 || strlen($_POST['bio'])>50 || count($_POST['topic'])>5){
            return false;
            }

        if(preg_match($regex, $_POST['name']) || preg_match($regex, $_POST['surname']) ||
            preg_match($regexExtended, $_POST['username']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
            (!empty($_POST['recoveryEmail']) && !filter_var($_POST['recoveryEmail'], FILTER_VALIDATE_EMAIL)) || $_POST['email'] == $_POST['recoveryEmail'] ||
            preg_match($regexPassword, $_POST['password']) || $_POST['password'] != $_POST['confirmPassword'] || $date > $thirteenYearsAgo){
            return false;
        }

        return true;
    }

function checkInputUsername(){
    $regexExtended = "/[^a-zA-Z0-9 _]/";
    if(preg_match($regexExtended, $_POST['username']) || strlen($_POST['username'])>30 || !isset($_POST['username'])){
        return false;
    } else {
        return true;
    }
}

function checkInputEmail(){
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['email'])>50 || !isset($_POST['email'])){
        return false;
    } else {
        return true;
    }
}

function checkInputPassword(){
    $regexPassword = "/[^a-zA-Z0-9 _!@#$%^*]/";
    if(preg_match($regexPassword, $_POST['password']) || strlen($_POST['password'])>30 || strlen($_POST['password'])<8 || !isset($_POST['password'])){
        return false;
    } else {
        return true;
    }
}

function check2FA($code){
    if(!isset($_SESSION['code2FA']) || strlen($code) != 10 || !ctype_xdigit($code)){
        return "false";
    }
     else if ($code == $_SESSION['code2FA']){
        return "true";
    } else {
        return "false";
        }
}

?>