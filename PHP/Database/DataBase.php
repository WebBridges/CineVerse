<?php

session_start();

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
        $hashedPassword =password_hash($_POST['password'],PASSWORD_DEFAULT);

        $stmt->bind_param("sssssssssb", $_POST['name'], $_POST['surname'], $_POST['username'], $_POST['email'], $recoveryEmail, $hashedPassword, $_POST['birthDate'], $gender, $_POST['bio'], $_POST['profilePicture']);
        $stmt->execute();

        $_SESSION['email'] = $_POST['email'];

        /*Insert topic of interest related with the new account*/
        foreach ($_POST['topic'] as $topic) {
            $query = "INSERT INTO topic_utente (Nome_tag_Topic, Username_Utente) VALUES (?, ?)";
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

    public function checkUsernameExistence($username){
        $query = "SELECT Username FROM utente WHERE Username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0)
            return "Username_exist";
        else
            return "Username_available";
    }

    public function checkEmailExistence($email){
        $query = "SELECT Email FROM utente WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0)
            return "Email_exist";
        else
            return "Email_available";
    }

    public function checkPassword($password,$email){
        $query = "SELECT Password FROM utente WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        if(password_verify($password,$hashedPassword)){
            $_SESSION['email'] = $email;
            return "Password_correct";
        } else {
            return "Password_wrong";
        }
    }

    public function active2FA(){
        $query = "UPDATE utente SET 2FA = 1 WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
    }

    public function setCode2FA(){
        $code = bin2hex(random_bytes(5));
        $_SESSION['code2FA'] = $code;
        echo $code;
        if($_SESSION['code2FA'] != NULL){
            return "true";
        } else {
            return "false";
        }
    }

    public function sendCodeWithEmail(){

    }
    
    public function check2FA($code){
        if ($_SESSION['code2FA'] && $code == $_SESSION['code2FA']){
            unset($_SESSION['code2FA']);
            return "true";
        } else {
            return "false";
        }
    }
}
?>