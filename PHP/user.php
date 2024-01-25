<?php

namespace Utente {

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
        private $follower;
        private $seguiti;


        // TODO: add relationship to other user
        public function __construct($nome = null, $cognome = null, $username = null, $data_nascita = null, $email = null, 
            $email_recupero = null, $password = null, $foto_profilo = null, $sesso = null, $descrizione = null, $foto_background = null, $follower = null, $seguiti = null) {
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

        public function get_follower(){
            return $this->follower;
        }

        public function get_seguiti(){
            return $this->seguiti;
        }

        public function check_password(string $password) {
            return password_verify($password, $this->password);
        }
        
        public function db_serialize(\DBDriver $driver) {
            if ($this->password == null) {
                throw new \Exception("Password not set");
            }
            $sql = "INSERT INTO utente (nome, cognome, username, data_nascita, email, email_recupero, password, foto_profilo, sesso, descrizione, foto_background) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            try {
                $driver->query($sql, $this->nome, $this->cognome, $this->username, $this->data_nascita, $this->email, 
                        $this->email_recupero, $this->password, $this->foto_profilo, $this->sesso, $this->descrizione, $this->foto_background);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }

        }

        public function update_infos(\DBDriver $driver, string $nome, string $cognome, string $username, string $data_nascita, string $email, 
                string $email_recupero, string $foto_profilo, string $sesso, string $descrizione, string $foto_background) {
            $sql = "UPDATE utente SET nome = ?, cognome = ?, username = ?, data_nascita = ?, email = ?, email_recupero = ?, foto_profilo = ?, 
                    sesso = ?, descrizione = ?, foto_background = ? WHERE username = ?";
            try {
                $driver->query($sql, $nome, $cognome, $username, date($data_nascita), $email, $email_recupero, 
                $foto_profilo, $sesso, $descrizione, $foto_background, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
        }
    }

    class UserUtility {
        public static function get_utente_by_username($driver, string $username) {
            $sql = "SELECT u.*, 
            (SELECT COUNT(*) FROM relazione WHERE Username_Seguito = ?) as follower,
            (SELECT COUNT(*) FROM relazione WHERE Username_Segue = ?) as seguiti
            FROM utente u 
            WHERE u.username = ?;";
            try {
                $result = $driver->query($sql, $username, $username, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }

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

        public static function get_utente_by_email(\DBDriver $driver, string $email) {
            $user = null;
            $sql = "SELECT * FROM utente WHERE email = ?";
            try {
                $result = $driver->query($sql, $email);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
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

        public static function from_db_with_phone(\DBDriver $driver, string $phone) {
            $user = null;
            $sql = "SELECT * FROM user WHERE phone = ?";
            try {
                $result = $driver->query($sql, $phone);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user = new DBUser($row["username"], $row["email"], $row["name"], $row["surname"], $row["birth_date"], 
                        $row["profile_photo"], $row["background"], $row["bio"], $row["phone"], $row["password"], $row["online"]
                );
            } else {
                return null;
            }
            return $user;

        }

        public static function check_if_available(\DBDriver $driver, $username = "", $email = "", $phone = ""): void {
            if (!empty($username)) {
                $sql = "SELECT * FROM user WHERE username = ?";
                try {
                    $result = $driver->query($sql, $username);
                } catch (\Exception $e) {
                    throw new \Exception("Error while querying the database: " . $e->getMessage());
                }
                if ($result->num_rows > 0) {
                    throw new UsernameTaken("Username already taken");
                }
            } else if (!empty($email)) {
                $sql = "SELECT * FROM user WHERE email = ?";
                try {
                    $result = $driver->query($sql, $email);
                } catch (\Exception $e) {
                    throw new \Exception("Error while querying the database: " . $e->getMessage());
                }
                if ($result->num_rows > 0) {
                    throw new EmailTaken("Email already taken");
                }
            } else if (!empty($phone)) {
                $sql = "SELECT * FROM user WHERE phone = ?";
                try {
                    $result = $driver->query($sql, $phone);
                } catch (\Exception $e) {
                    throw new \Exception("Error while querying the database: " . $e->getMessage());
                }
                if ($result->num_rows > 0) {
                    throw new PhoneTaken("Phone already taken");
                }
            }
        }

        public static function retrieve_username_from_token($token): string {
            if (preg_match("/Bearer\s(\S+)/", $token, $matches) !== 1) {
                throw new \Exception("Invalid token");
            } else {
                $token = $matches[1];
                $decoded = JWT::decode($token, new Key(getenv("PL_JWTKEY"), 'HS256'));
                return ((array) $decoded)["username"];
            }
        }

        public static function retrieve_online_followed($driver, $username) {
            $sql = "SELECT u.* FROM user u, relationship r 
                    WHERE u.username = r.followed AND r.follows = ? AND u.online = 1";
            try {
                $result = $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
            $users = array();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_array();
                    $user = new DBUser($row["username"], $row["email"], $row["name"], $row["surname"], $row["birth_date"], 
                            $row["profile_photo"], $row["background"], $row["bio"], $row["phone"], $row["password"], $row["online"]);
                    array_push($users, $user);
                }
            }
            return $users;
        }

        public static function retrieve_profile_picture($driver, $username) {
            $sql = "SELECT profile_photo FROM user WHERE username = ?";
            try {
                $result = $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["profile_photo"];
            } else {
                return null;
            }
        }

        public static function retrieve_settings($driver, $username) {
            $sql = "SELECT * FROM settings WHERE username = ?";
            try {
                $result = $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $settings = new DBSettings($row["username"], $row["language"], $row["notifications"], $row["2fa"], $row["organizer"]);
            } else {
                return null;
            }
            return $settings;
        }

        public static function retrieve_followers($driver, $username) {
            $sql = "SELECT u.* FROM user u, relationship r 
                    WHERE u.username = r.follows
                    AND r.followed = ?";
            try {
                $result = $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
            $users = array();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_array();
                    $user = new DBUser($row["username"], $row["email"], $row["name"], $row["surname"], $row["birth_date"], 
                            $row["profile_photo"], $row["background"], $row["bio"], $row["phone"], $row["password"], $row["online"]);
                    array_push($users, $user);
                }
            }
            return $users;
        }

        public static function retrieve_email($driver, $username) {
            $sql = "SELECT email FROM user WHERE username = ?";
            try {
                $result = $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["email"];
            } else {
                return null;
            }
        }

        public static function insert_tfa($driver, $username, $code) {
            $sql = "SELECT username FROM tfa_code WHERE username = ?";
            try {
                $result = $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
            if($result->num_rows > 0) {
                $sql = "UPDATE tfa_code SET code = ? WHERE username = ?";
                try {
                    $driver->query($sql, $code, $username);
                } catch (\Exception $e) {
                    throw new \Exception("Error while querying the database: " . $e->getMessage());
                }
            } else {
                $sql = "INSERT INTO tfa_code (username, code) VALUES (?, ?)";
                try {
                    $driver->query($sql, $username, $code);
                } catch (\Exception $e) {
                    throw new \Exception("Error while querying the database: " . $e->getMessage());
                }
            }
        }

        public static function retrieve_tfa($driver, $username) {
            $sql = "SELECT code FROM tfa_code WHERE username = ?";
            try {
                $result = $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["code"];
            } else {
                return null;
            }
        }

        public static function reset_tfa($driver, $username) {
            $sql = "UPDATE tfa_code SET code = 0 WHERE username = ?";
            try {
                $driver->query($sql, $username);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
        }
    }
    class UsernameTaken extends \Exception { }
    class EmailTaken extends \Exception { }
    class PhoneTaken extends \Exception { }
}

?>