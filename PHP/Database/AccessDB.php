<?php
//include "../Utils/CheckInputForms.php";
require_once ("../Bootstrap.php");
sec_session_start();
include_once "../CheckInputForms.php";

     function insertNewAccount(){
        /*Insert a new account in database*/

        if(\validateRegistrationInfo() && checkUsernameExistence($_POST['username']) == "Username_available" && checkEmailExistence($_POST['email']) == "Email_available"){
            $db = getDb();

            $query = "INSERT INTO utente (Nome, Cognome, Username, Email, Email_di_recupero, Password, Data_nascita, Sesso, Descrizione, Foto_profilo ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);

            $recoveryEmail = isset($_POST['recoveryEmail']) ? $_POST['recoveryEmail'] : NULL;
            $gender = isset($_POST['gender']) ? $_POST['gender'] : NULL;
            $hashedPassword =password_hash($_POST['password'],PASSWORD_DEFAULT);

            $stmt->bind_param("sssssssssb", $_POST['name'], $_POST['surname'], $_POST['username'], $_POST['email'], $recoveryEmail, $hashedPassword, $_POST['birthDate'], $gender, $_POST['bio'], $_POST['profilePicture']);
            $stmt->execute();

            $_SESSION['email'] = $_POST['email'];

            /*Insert topic of interest related with the new account*/
            foreach ($_POST['topic'] as $topic) {
                $query = "INSERT INTO topic_utente (Nome_tag_Topic, Username_Utente) VALUES (?, ?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss", $topic, $_POST['username']);
                $stmt->execute();
            }
            
            /*creation of a new usercookie*/
            if (!isset($_COOKIE['email'])) {
                setcookie('email', $_POST['email'], [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => false,  // This means the cookie will only be set if a secure HTTPS connection exists.
                    'httponly' => true,  // This means the cookie can only be accessed through the HTTP protocol and not by scripting languages like JavaScript.
                    'samesite' => 'Strict',  // This can prevent the cookie from being sent in some cross-site requests, improving security.
                ]);
            }
            return true;
        } else {
            return false;
        }
    }
    
     function insertTopic($topic){
        $db = getDb();

        $query = "INSERT INTO topic (Nome_tag) VALUES (?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $topic);
        $stmt->execute();
    }

     function checkUsernameExistence($username){
        $db = getDb();
        
        if(!\checkInputUsername()){
            return "Username_invalid";
        }
        $query = "SELECT Username FROM utente WHERE Username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0)
            return "Username_exist";
        else
            return "Username_available";
    }

     function checkEmailExistence($email){
        $db = getDb();

        if(\checkInputEmail()){
            $query = "SELECT Email FROM utente WHERE Email = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows > 0)
                return "Email_exist";
            else
                return "Email_available";
        } else {
            return "Email_invalid";
        }
    }

     function checkPassword($password,$email){
        $db = getDb();
        
        if(!\checkInputPassword() || !\checkInputEmail()){
            return "Password_invalid";
        }
        $query = "SELECT Password FROM utente WHERE Email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        if(password_verify($password,$hashedPassword)){
            $_SESSION['email'] = $email;
            if (!isset($_COOKIE['email'])) {
                setcookie('email', $_POST['email'], [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => false,  // This means the cookie will only be set if a secure HTTPS connection exists.
                    'httponly' => true,  // This means the cookie can only be accessed through the HTTP protocol and not by scripting languages like JavaScript.
                    'samesite' => 'Strict',  // This can prevent the cookie from being sent in some cross-site requests, improving security.
                ]);
            }
            return "Password_correct";
        } else {
            return "Password_wrong";
        }
    }

     function active2FA(){
        $db = getDb();

        $query = "UPDATE utente SET 2FA = 1 WHERE Email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
    }

     function setCode2FA(){
        $now = time();
        if (!isset($_SESSION['lastTime'])) {
            $_SESSION['lastTime'] = 0;
        }
        $lastTime = $_SESSION['lastTime'];
        $waitTime = 30;
        if($now - $lastTime < $waitTime){
            return "false";
        }
        $_SESSION['lastTime'] = $now;
        $code = bin2hex(random_bytes(5));
        $_SESSION['code2FA'] = $code;
        echo $_SESSION['code2FA'];
        if($_SESSION['code2FA'] != NULL){
            return "true";
        } else {
            return "false";
        }
    }

     function sendCodeWithEmail(){

    }

     function check2FA_Active(){
        $db = getDb();

        $query = "SELECT 2FA FROM utente WHERE Email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($active);
        $stmt->fetch();
        if($active !=NULL && $active == 1){
            return true;
        } else {
            return false;
        }
    }


?>