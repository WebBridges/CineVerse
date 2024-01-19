<?php

class DataBase{

    private $db;

    public function __construct($host, $user, $pass, $db){
        $this->db = new mysqli($host, $user, $pass, $db);
        if ($this->db->connect_errno) {
            die("Connection failed: " . $this->db->connect_error);
        }
        
    }
   
    public function close(){
        $this->db->close();
    }

    public function insertNewAccount(){
        /*Insert a new account in database*/
        $query = "INSERT INTO utente (Nome, Cognome, Username, Email, Email_di_recupero, Password, Data_nascita, Sesso, Descrizione, Foto_profilo ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        $recoveryEmail = isset($_POST['recoveryEmail']) ? $_POST['recoveryEmail'] : NULL;
        $gender = isset($_POST['gender']) ? $_POST['gender'] : NULL;

        $stmt->bind_param("sssssssssb", $_POST['name'], $_POST['surname'], $_POST['username'], $_POST['email'], $recoveryEmail, $_POST['password'], $_POST['birthDate'], $gender, $_POST['bio'], $_POST['profilePicture']);
        $stmt->execute();

        /*Insert topic of interest related with the new account*/
        foreach ($_POST['topic'] as $topic) {
            $query = "INSERT INTO topic_utente (Nome_tag, Username) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $topic, $_POST['username']);
            $stmt->execute();
        }
    }
    
    public function insertTopic($topic){
        $query = "INSERT INTO topic (Nome_tag) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $topic);
        $stmt->execute();
    }
}
?>