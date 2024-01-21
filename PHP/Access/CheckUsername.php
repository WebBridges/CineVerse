<?php
require_once("../Bootstrap.php");
echo $db->CheckUsernameExistence($_POST['username']);
?>