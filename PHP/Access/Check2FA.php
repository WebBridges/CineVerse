<?php
    require_once("../Database/AccessDB.php");
    echo check2fa($_POST['code']);
?>