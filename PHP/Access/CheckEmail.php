<?php
    require_once("../Database/AccessDB.php");
    echo checkEmailExistence($_POST['email']);
?>