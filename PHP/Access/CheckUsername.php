<?php
    require_once("../Database/AccessDB.php");
    echo checkUsernameExistence($_POST['username']);
?>