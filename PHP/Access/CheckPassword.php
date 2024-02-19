<?php
    require_once("../Database/AccessDB.php");
    echo checkPassword($_POST['password'],$_POST['email']);
?>