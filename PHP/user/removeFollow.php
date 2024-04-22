<?php
    Use User\UserUtility;
    require_once ("../Utils/user.php");
    
    $user= new UserUtility();
    try{
        $user::removeFollow($_POST['usernameURL']);
        echo json_encode(true);
    }catch(Exception $e){
        echo json_encode(false);
    }
?>