<?php
require_once("../Utils/Bootstrap.php");
echo $db->CheckEmailExistence($_POST['email']);
?>