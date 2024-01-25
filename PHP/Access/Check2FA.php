<?php
    require_once("../db/AccessDB.php");
    echo check2FA($POST['code']);
?>