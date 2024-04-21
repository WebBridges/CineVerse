<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


#Sistemare sistema di salvataggio e verifica dell'account
#Sistemare invio email e creazione token temporaneo
#Implementare il token dell'utente con jwt (chiave pubblica,crittografia,dati) per implementare meglio il fatto di salvare la sessione (anche li bisogna lavorarci)

require_once (__DIR__ . "/../Utils/bootstrap.php");
sec_session_start();
include_once (__DIR__ . "/../Utils/CheckInputForms.php");
include_once (__DIR__ . "/../Utils/emailUtils.php");
include_once (__DIR__ . "/../Utils/authUtilities.php");


     function insertNewAccount(){
        /*Insert a new account in database*/

        if(\validateRegistrationInfo() && checkUsernameExistence($_POST['username']) == "Username_available" && checkEmailExistence($_POST['email']) == "Email_available"){
            $db = getDb();

            $query = "INSERT INTO utente (Nome, Cognome, Username, Email, Password, Data_nascita, Sesso, Descrizione, Foto_profilo, Foto_background, 2FA ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
            $stmt = $db->prepare($query);

            $gender = isset($_POST['gender']) ? $_POST['gender'] : NULL;
            $hashedPassword =password_hash($_POST['password'],PASSWORD_DEFAULT);
            $void=NULL;

            $stmt->bind_param("sssssssss", $_POST['name'], $_POST['surname'], $_POST['username'], $_POST['email'], $hashedPassword, $_POST['birthDate'], $gender, $void,"default-user.jpg","default-background.jpg");
            $stmt->execute();

            $_SESSION['email'] = $_POST['email'];
            $_SESSION['username'] = $_POST['username'];

            /*Insert topic of interest related with the new account*/
            foreach ($_POST['topic'] as $topic) {
                $query = "INSERT INTO topic_utente (Nome_tag_Topic, Username_Utente) VALUES (?, ?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss", $topic, $_POST['username']);
                $stmt->execute();
            }
            return true;
        } else {
            return false;
        }
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

     function checkUsername_for_cookie($username){
        $db = getDb();
        $query = "SELECT Username FROM utente WHERE Username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0)
            return "Username_exist";
        else
            return "Username_not_exist";
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
        $hashedPassword="";
        if( !\checkInputEmail() || !\checkInputPassword()){
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
            return "Password_correct";
        } else {
            return "Password_wrong";
        }
    }
    
     function processLogin($email){
        $db = getDb();
        $username="";
        $_SESSION['email'] = $email;
        $query="SELECT Username FROM utente WHERE Email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username);
        $stmt->fetch();
        $_SESSION['username'] = $username;
        $_SESSION['remember'] = isset($_POST['remember']) ? "on" : "off";
     }

     function active2FA(){
        $db = getDb();
        $query = "UPDATE utente SET 2FA = 1 WHERE Email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $_SESSION['email']);
        $stmt->execute();
        unset($_SESSION['email']);
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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $token = '';
        $tokenLength = 128;
        for ($i = 0; $i < $tokenLength; $i++) {
            $token .= $characters[random_int(0, $charactersLength - 1)];
        }

        if($code != NULL && $token != NULL){
            addTfa($_SESSION['username'],$code,$token);
            sendCodeWithEmail($code);
            $_SESSION['token'] = $token;
            return "true";
        } else {
            return "false";
        }
    }

     function sendCodeWithEmail($code){
        $subject="2FA CODE";
        $message='<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
        <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h1 style="text-align: center; color: #333;">Autenticazione a due fattori</h1>
            <p style="margin-bottom: 20px; color: #666; text-align: center;">Salve,</p>
            <p style="margin-bottom: 20px; color: #666; text-align: center;">Per favore, inserisci il seguente codice per completare la procedura di autenticazione a due fattori:</p>
            <div style="text-align: center; font-size: 24px; color: #007bff; margin-bottom: 30px;">' . $code . '</div>
            <p style="margin-bottom: 20px; color: #666; text-align: center;">Se non hai richiesto questo codice, per favore ignora questa email.</p>
        </div>
        </body>';
        sendEmailMessage($subject, $message, $_SESSION['email']);
    }

     function check2FA_Active(){
        $db = getDb();
        $active="";

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
            set_token_cookie($_SESSION['username'],$_SESSION['remember']);
            return false;
        }
    }

    function addTfa($username,$code,$token){
        $db = getDb();
        $query = "INSERT INTO tfa_auth (username, code, token) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE code = ?, token = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sssss", $username, $code, $token, $code, $token);
        $stmt->execute();
    }

    function check2fa($insertedCode){
        $rightCode = retrieveCode();
        if($insertedCode == $rightCode){
            return "true";   
        } else {
                return "false";
            }
        }

    function checkAuthTfa($insertedCode){
        if(check2fa($insertedCode) == "true"){
            $username=retrieveUsername();
            if($username != NULL){
                set_token_cookie($username,$_SESSION['remember']);
                deleteCode();
                return "true";
            }
        } else {
            return "false";
        }
    }

    function retrieveCode(){
        $db = getDb();
        $sql = "SELECT code FROM tfa_auth WHERE token = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $_SESSION['token']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["code"];
        } else {
            return null;
        }
    }

    function deleteCode(){
        $db = getDb();
        $sql = "DELETE FROM tfa_auth WHERE token = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $_SESSION['token']);
        $stmt->execute();
    }

    function retrieveUsername(){
        $db = getDb();
        $sql = "SELECT username FROM tfa_auth WHERE token = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $_SESSION['token']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["username"];
        } else {
            return null;
        }
    }

    function retrieveUsername_from_token($token){
        if (preg_match("/Bearer\s(\S+)/", $token, $matches) !== 1) {
            throw new \Exception("Invalid token 1");
        } else {
            $token = $matches[1];
            try {
                $decoded = JWT::decode($token, new Key(getenv("JWTKEY"), 'HS256'));
                if(checkUsername_for_cookie(((array) $decoded)["username"])=="Username_exist"){
                    return ((array) $decoded)["username"];
                } else {
                    throw new \Exception("Invalid token 2");
                }
            } catch (\Exception $e) {
                throw new \Exception("Invalid token 3" . $token . "   ");
            }
        }
    }

?>