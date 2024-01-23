<?php
    require_once("../Bootstrap.php");
    echo $db->checkPassword($_POST['password'],$_POST['email']);
?>