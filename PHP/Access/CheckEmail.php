<?php
require_once("../Bootstrap.php");
echo $db->CheckEmailExistence($_POST['email']);
?>