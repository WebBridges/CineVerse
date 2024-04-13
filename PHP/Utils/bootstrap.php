<?php
/*Raggruppiamo tutti gli elementi condivisi tra i vari php */
 require_once(__DIR__ . "/Session.php");
sec_session_start();

require_once(__DIR__ . "/CheckInputForms.php");
require_once(__DIR__ . "/../Database/DataBase.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$database = DataBase::getInstance("sql11.freesqldatabase.com", "sql11698630", "D8iesRmkrX", "sql11698630");
$db = $database->getDatabase();

function getDb() {
    global $db;
    return $db;
}
?>