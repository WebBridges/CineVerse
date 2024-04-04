<?php

function validateRegistrationInfo(){
        $regex = "/[^a-zA-Z ]/";
        $regexExtended = "/[^a-zA-Z0-9 _]/";
        $regexPassword = "/[^a-zA-Z0-9 _!@#$%^*]/";
        $date = DateTime::createFromFormat('d-m-Y', $_POST['birthDate']);
        $fourteenYearsAgo = (new DateTime())->modify('-14 years');

        //verify if all the fields are set
        if(!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['username']) || !isset($_POST['email']) ||
        !isset($_POST['password']) || !isset($_POST['confirmPassword']) || !isset($_POST['birthDate']) || !isset($_POST['topic'])){
            return false;
        }

        //verify if the fields exceed the maximum or minimum length
        if(strlen($_POST['name'])>30 || strlen($_POST['surname'])>30 || strlen($_POST['username'])>30 ||
            strlen($_POST['email'])>50 || strlen($_POST['password'])>30 || strlen($_POST['password'])<8 ||
             strlen($_POST['confirmPassword'])>30 || count($_POST['topic'])>5){
                return false;
            }

        if(preg_match($regex, $_POST['name']) || preg_match($regex, $_POST['surname']) || preg_match($regexExtended, $_POST['username']) || 
             !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || preg_match($regexPassword, $_POST['confirmPassword']) ||
             preg_match($regexPassword, $_POST['password']) || $_POST['password'] != $_POST['confirmPassword'] || $date > $fourteenYearsAgo){
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
        $_SESSION['2FA'] = 1;
        return "true";
    } else {
        return "false";
        }
}

?>