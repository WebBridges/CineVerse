<?php
    require_once("../db/AccessDB.php");
    echo checkEmailExistence($_POST['email']);
?>