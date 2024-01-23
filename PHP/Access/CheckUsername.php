<?php
require_once("../Bootstrap.php");
echo $db->checkUsernameExistence($_POST['username']);
?>