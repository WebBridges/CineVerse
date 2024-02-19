<?php
    require_once("../Database/AccessDB.php");
    echo check2FA($POST['code']);
?>