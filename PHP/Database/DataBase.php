<?php

class DataBase {

    private static $instance = null;
    private $db;

    private function __construct($host, $user, $pass, $db) {
        $this->db = new mysqli($host, $user, $pass, $db);
        if ($this->db->connect_errno) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public static function getInstance($host, $user, $pass, $db) {
        if (self::$instance == null) {
            self::$instance = new DataBase($host, $user, $pass, $db);
        }
        return self::$instance;
    }

    public function getDatabase() {
        return $this->db;
    }

    public function close() {
        $this->db->close();
    }
}

?>