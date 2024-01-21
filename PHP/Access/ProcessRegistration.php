<?php
    require_once("../Bootstrap.php");
    $db->insertNewAccount();
    //da cambiare il percorso
    header("Location: ../2authLogin.html")
?>