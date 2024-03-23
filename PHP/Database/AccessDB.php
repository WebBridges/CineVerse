<?php
//include "../Utils/CheckInputForms.php";

use SendGrid\Mail\Mail;

#Sistemare sistema di salvataggio e verifica dell'account
#Sistemare invio email e creazione token temporaneo
#Implementare il token dell'utente con jwt (chiave pubblica,crittografia,dati) per implementare meglio il fatto di salvare la sessione (anche li bisogna lavorarci)

require_once ("../Utils/bootstrap.php");
sec_session_start();
include_once "../Utils/CheckInputForms.php";


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
            $_SESSION['username'] = $_POST['username'];

            setCookies();

            /*Insert topic of interest related with the new account*/
            foreach ($_POST['topic'] as $topic) {
                $query = "INSERT INTO topic_utente (Nome_tag_Topic, Username_Utente) VALUES (?, ?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss", $topic, $_POST['username']);
                $stmt->execute();
            }
            
            setCookies();

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
        $hashedPassword="";
        $username="";
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
            $_SESSION['email'] = $email;
            $query="SELECT Username FROM utente WHERE Email = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($username);
            $stmt->fetch();
            $_SESSION['username'] = $username;
            setCookies();
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
            sendCodeWithEmail();
            return "true";
        } else {
            return "false";
        }
    }

     function sendCodeWithEmail(){
        $sender = new \SendGrid\Mail\Mail();
        $sender->setFrom("webbridgemail@gmail.com", "noreply");
        $sender->setSubject("2FA CODE");
        $sender->addTo($_SESSION['email']);
        $sender->addContent(
            "text/plain","Il codice di F2A è: ".$_SESSION['code2FA']
        );
        $sendgrid= new \SendGrid(getenv("MailApiKey"));
        $sendgrid->send($sender);
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
            return false;
        }
    }

    function setCookies(){
        if(isset($_COOKIE['email'])){
            setcookie('email', '', time() - 3600, '/');
        }
        /*creation of a new usercookie*/
        if (!isset($_COOKIE['email'])) {
            setcookie('email', $_SESSION['email'], [
                'expires' => time() + 3600,
                'path' => '/',
                'secure' => false,  
                'httponly' => true, 
                'samesite' => 'Strict', 
            ]);
        }

        if(isset($_COOKIE['username'])){
            setcookie('username', '', time() - 3600, '/');
        }

        if (!isset($_COOKIE['username'])) {
            setcookie('username', $_SESSION['username'], [
                'expires' => time() + 3600,
                'path' => '/',
                'secure' => false,  
                'httponly' => true,  
                'samesite' => 'Strict',
            ]);
        }
    }

?>