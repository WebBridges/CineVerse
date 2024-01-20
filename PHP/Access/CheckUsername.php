<?php
require_once("../Utils/Bootstrap.php");
echo $db->CheckUsernameExistence($_POST['username']);
?>