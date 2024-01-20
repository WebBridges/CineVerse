<?php
    require_once("../Bootstrap.php");
    echo $db->CheckPassword($_POST['password'],$_POST['email']);
?>