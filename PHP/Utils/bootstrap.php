<?php
/*Raggruppiamo tutti gli elementi condivisi tra i vari php */
require_once("Session.php");
sec_session_start();

require_once("CheckInputForms.php");
require_once("../db/Database.php");

$database = DataBase::getInstance("localhost", "root", "", "cineverse", 3306);
$db = $database->getDatabase();

function getDb() {
    global $db;
    return $db;
}
?>