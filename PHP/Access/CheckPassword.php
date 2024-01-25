<?php
    require_once("../db/AccessDB.php");
    echo checkPassword($_POST['password'],$_POST['email']);
?>