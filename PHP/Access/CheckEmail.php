<?php
require_once("../Bootstrap.php");
echo $db->checkEmailExistence($_POST['email']);
?>