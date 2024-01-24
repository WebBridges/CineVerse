<?php
    require_once("../Bootstrap.php");
    include "../CheckInputForms.php";
    echo check2FA($POST['code']);
?>