<?php

use User\DBUtente;

    require_once("../Database/AccessDB.php");
    require_once("../Utils/user.php");
    require_once("../Utils/CheckInputForms.php");

    $password= isset($_POST['password']) ? $_POST['password'] : "";
    $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
    $tFA = (isset($_POST['checkboxTFA']) && $_POST['checkboxTFA'] == "on") ? 1 : 0;

    if(!checkInputEmail() || !checkInputUsername() || !checkUpdateInfosAccount()){
        http_response_code(400); // Bad Request
        echo "Invalid input";
        exit();
    } else if ($password != ""){
        if(!checkInputPassword()){
            http_response_code(400); // Bad Request
            echo "Invalid input";
            exit();
        }
    }

    try{
        $user = new DBUtente();
        $user->update_infos_account($_POST['name'], $_POST['surname'],$_POST['username'],$_POST['birthDate'],$_POST['email'],$gender,$tFA);
        if($password != ""){
            $user->update_password($password);
        }
        header("Location: ../../HTML/Profile/userpage.php");

    }catch(Exception $e){
        http_response_code(400); // Bad Request
        echo $e->getMessage();
    }
?>