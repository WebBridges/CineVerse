<?php
    require_once("../db/AccessDB.php");
    echo checkUsernameExistence($_POST['username']);
?>