<?php
    require_once("../Utils/Bootstrap.php");
    $db->insertNewAccount();
    //da cambiare il percorso
    header("Location: ../../Access/2authLogin.html")
?>