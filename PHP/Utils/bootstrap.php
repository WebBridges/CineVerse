<?php
/*Raggruppiamo tutti gli elementi condivisi tra i vari php */
require_once("Session.php");
sec_session_start();

require_once("CheckInputForms.php");
require_once("../db/DataBase.php");
$db = new DataBase("localhost", "root", "", "cineverse", 3306);
?>