<?php

namespace Utente {

    require_once ("bootstrap.php");

    class DBUtente{
        private $nome;
        private $cognome;
        private $username;
        private $data_nascita;
        private $email;
        private $email_recupero;
        private $password;
        private $foto_profilo;
        private $sesso;
        private $descrizione;
        private $foto_background;
        private $tFA;
        private $follower;
        private $seguiti;


        // TODO: add relationship to other user
        public function __construct($nome = null, $cognome = null, $username = null, $data_nascita = null, $email = null, 
            $email_recupero = null, $password = null, $foto_profilo = null, $sesso = null, $descrizione = null, $foto_background = null, $tFA = null, $follower = null, $seguiti = null) {
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->username = $username;
            $this->data_nascita = $data_nascita;
            $this->email = $email;
            $this->email_recupero = $email_recupero;
            $this->password = $password;
            $this->foto_profilo = $foto_profilo;
            $this->sesso = $sesso;
            $this->descrizione = $descrizione;
            $this->foto_background = $foto_background;
            $this->tFA = $tFA;
            $this->follower = $follower;
            $this->seguiti = $seguiti;
        }
        
        public function get_nome(){
            return $this->nome;
        }

        public function get_cognome(){
            return $this->cognome;
        }

        public function get_username(){
            return $this->username;
        }

        public function get_data_nascita(){
            return $this->data_nascita;
        }

        public function get_email(){
            return $this->email;
        }

        public function get_email_recupero(){
            return $this->email_recupero;
        }

        public function get_password(){
            return $this->password;
        }

        public function get_foto_profilo(){
            return $this->foto_profilo;
        }

        public function get_sesso(){
            return $this->sesso;
        }

        public function get_descrizione(){
            return $this->descrizione;
        }

        public function get_foto_background(){
            return $this->foto_background;
        }

        public function get_2FA(){
            return $this->tFA;
        }

        public function get_follower(){
            return $this->follower;
        }

        public function get_seguiti(){
            return $this->seguiti;
        }

        public function check_password(string $password) {
            return password_verify($password, $this->password);
        }
        
        public function db_serialize() {
            $db = getDB();
            if ($this->password == null) {
                throw new \Exception("Password not set");
            }
            
            $query = "INSERT INTO utente (nome, cognome, username, data_nascita, email, email_recupero, password, foto_profilo, sesso, descrizione, foto_background, tFA) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sssssssbssbi", $this->nome, $this->cognome, $this->username, $this->data_nascita, $this->email, 
                $this->email_recupero, $this->password, $this->foto_profilo, $this->sesso, $this->descrizione, $this->foto_background, $this->tFA);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
        }

        public function update_infos(string $nome, string $cognome, string $username, string $data_nascita, string $email, 
                string $email_recupero, string $foto_profilo, string $sesso, string $descrizione, string $foto_background, int $tFA) {
            $db = getDB();
            $query = "UPDATE utente SET nome = ?, cognome = ?, username = ?, data_nascita = ?, email = ?, email_recupero = ?, foto_profilo = ?, 
                sesso = ?, descrizione = ?, foto_background = ?, 2FA = ? WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssssssbssbis", $nome, $cognome, $username, $data_nascita, $email, $email_recupero, $foto_profilo, $sesso, $descrizione, $foto_background, $tFA, $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
        }
    }

    class UserUtility {
        public static function get_utente_by_username(string $username) {
            $db = getDB();
            $query = "SELECT u.*, 
                (SELECT COUNT(*) FROM relazione WHERE Username_Seguito = ?) as follower,
                (SELECT COUNT(*) FROM relazione WHERE Username_Segue = ?) as seguiti
                FROM utente u 
                WHERE u.username = ?;";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sss", $username, $username, $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user = new DBUtente($row["nome"], $row["cognome"], $row["username"], $row["data_nascita"], $row["email"], 
                        $row["email_recupero"], $row["password"], $row["foto_profilo"], $row["sesso"], $row["descrizione"], 
                        $row["foto_background"], $row["follower"], $row["seguiti"]
                );
            } else {
                return null;
            }
            return $user;
        }

        public static function get_utente_by_email(string $email) {
            $db = getDB();
            $query = "SELECT * FROM utente WHERE email = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $email);
            $success = $stmt->execute();
            if(!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user = new DBUtente($row["nome"], $row["cognome"], $row["username"], $row["data_nascita"], $row["email"], 
                    $row["email_recupero"], $row["password"], $row["foto_profilo"], $row["sesso"], $row["descrizione"], 
                    $row["foto_background"]
                );
            } else {
                return null;
            }
            return $user;

        }

        public static function check_if_available($username = "", $email = ""): void {
            $db = getDB();
            if (!empty($username)) {
                $query = "SELECT * FROM utente WHERE username = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $username);
                $success = $stmt->execute();
                if (!$success) {
                    throw new \Exception("Error while querying the database: " . mysqli_error($db));
                }

                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    throw new \Exception("Username already taken");
                }
            } else if (!empty($email)) {
                $query = "SELECT * FROM utente WHERE email = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $email);
                $success = $stmt->execute();
                if (!$success) {
                    throw new \Exception("Error while querying the database: " . mysqli_error($db));
                }
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    throw new \Exception("Email already taken");
                }
            }
        }

        public static function retrieve_followed($username) {
            $db = getDB();
            $query = "SELECT u.* FROM utente u, relazione r 
                    WHERE u.username = r.Username_Seguito AND r.Username_Segue = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();
            $users = array();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_array();
                    $user = new DBUtente($row["nome"], $row["cognome"], $row["username"], $row["data_nascita"], $row["email"], 
                            $row["email_recupero"], $row["password"], $row["foto_profilo"], $row["sesso"], $row["descrizione"], 
                            $row["foto_background"]);
                    array_push($users, $user);
                }
            }
            return $users;
        }

        public static function retrieve_profile_photo($username) {
            $db = getDB();
            $query = "SELECT foto_profilo FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["foto_profilo"];
            } else {
                return null;
            }
        }

        public static function retrieve_background($username) {
            $db = getDB();
            $query = "SELECT foto_background FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["foto_background"];
            } else {
                return null;
            }
        }

        public static function retrieve_bio($username) {
            $db = getDB();
            $query = "SELECT descrizione FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["descrizione"];
            } else {
                return null;
            }
        }
        public static function retrieve_followers($username) {
            $db = getDB();
            $query = "SELECT u.* FROM utente u, relazione r 
                    WHERE u.username = r.Username_Segue AND r.Username_Seguito = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();
            $users = array();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_array();
                    $user = new DBUtente($row["nome"], $row["cognome"], $row["username"], $row["data_nascita"], $row["email"], 
                            $row["email_recupero"], $row["password"], $row["foto_profilo"], $row["sesso"], $row["descrizione"], 
                            $row["foto_background"]);
                    array_push($users, $user);
                }
            }
            return $users;
        }

        public static function retrieve_email($username) {
            $db = getDB();
            $query = "SELECT email FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if(!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["email"];
            } else {
                return null;
            }
        }

        public static function insert_2FA($username, $code) {
            $db = getDB();
            $query = "SELECT username FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if(!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $query = "UPDATE utente SET 2FA = ? WHERE username = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss", $code, $username);
                $success = $stmt->execute();
                if(!$success) {
                    throw new \Exception("Error while querying the database: " . mysqli_error($db));
                }
            } else {
                throw new \Exception("Error while querying the database: ");
            }
        }

        public static function retrieve_2FA($username) {
            $db = getDB();
            $query = "SELECT 2FA FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if(!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["2FA"];
            } else {
                return null;
            }
        }
    }
}

?>