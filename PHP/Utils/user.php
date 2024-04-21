<?php

namespace User {

    require_once("bootstrap.php");
    sec_session_start();
    require_once("dbObject.php");
    require_once("authUtilities.php");

    class DBUtente implements \DBObject
    {
        private $nome;
        private $cognome;
        private $username;
        private $data_nascita;
        private $email;
        private $password;
        private $foto_profilo;
        private $sesso;
        private $descrizione;
        private $foto_background;
        private $tFA;
        private $follower;
        private $seguiti;
        private $topics;


        // TODO: add relationship to other user
        public function __construct(
            $nome = null,
            $cognome = null,
            $username = null,
            $data_nascita = null,
            $email = null,
            $password = null,
            $foto_profilo = null,
            $sesso = null,
            $descrizione = null,
            $foto_background = null,
            $tFA = null,
            $follower = null,
            $seguiti = null,
            $topics = null
        ) {
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->username = $username;
            $this->data_nascita = $data_nascita;
            $this->email = $email;
            $this->password = $password;
            $this->foto_profilo = $foto_profilo;
            $this->sesso = $sesso;
            $this->descrizione = $descrizione;
            $this->foto_background = $foto_background;
            $this->tFA = $tFA;
            $this->follower = $follower;
            $this->seguiti = $seguiti;
            $this->topics = $topics;
        }

        public function jsonSerialize()
        {
            return [
                "Nome" => $this->nome,
                "Cognome" => $this->cognome,
                "Username" => $this->username,
                "Data_nascita" => $this->data_nascita,
                "Email" => $this->email,
                "Password" => $this->password,
                "Foto_profilo" => $this->foto_profilo,
                "Sesso" => $this->sesso,
                "Descrizione" => $this->descrizione,
                "Foto_background" => $this->foto_background,
                "tFA" => $this->tFA,
                "Follower" => $this->follower,
                "Seguiti" => $this->seguiti,
                "topics" => $this->topics
            ];
        }

        public function get_nome()
        {
            return $this->nome;
        }

        public function get_cognome()
        {
            return $this->cognome;
        }

        public function get_username()
        {
            return $this->username;
        }

        public function get_data_nascita()
        {
            return $this->data_nascita;
        }

        public function get_email()
        {
            return $this->email;
        }

        public function get_password()
        {
            return $this->password;
        }

        public function get_foto_profilo()
        {
            return $this->foto_profilo;
        }

        public function get_sesso()
        {
            return $this->sesso;
        }

        public function get_descrizione()
        {
            return $this->descrizione;
        }

        public function get_foto_background()
        {
            return $this->foto_background;
        }

        public function get_2FA()
        {
            return $this->tFA;
        }

        public function get_follower()
        {
            return $this->follower;
        }

        public function get_seguiti()
        {
            return $this->seguiti;
        }

        public function get_topics()
        {
            return $this->topics;
        }

        public function set_topics($topics)
        {
            $this->topics = $topics;
        }

        public function check_password(string $password)
        {
            return password_verify($password, $this->password);
        }

        public function db_serialize()
        {
            $db = getDB();
            if ($this->password == null) {
                throw new \Exception("Password not set");
            }

            $query = "INSERT INTO utente (nome, cognome, username, data_nascita, email, password, foto_profilo, sesso, descrizione, foto_background, tFA) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param(
                "sssssssbssbi",
                $this->nome,
                $this->cognome,
                $this->username,
                $this->data_nascita,
                $this->email,
                $this->password,
                $this->foto_profilo,
                $this->sesso,
                $this->descrizione,
                $this->foto_background,
                $this->tFA
            );
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
        }

        public function update_infos_account(
            string $nome,
            string $cognome,
            string $username,
            string $data_nascita,
            string $email,
            string $sesso,
            int $tFA,
            array $topic
        ) {
            $db = getDB();
            $query = "UPDATE utente SET Nome = ?, Cognome = ?, Username = ?, Data_nascita = ?, Email = ?, 
                Sesso = ?, 2FA = ? WHERE Username = ?";
            $gender=$sesso!=""?$sesso:null;
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssssssis", $nome, $cognome, $username, $data_nascita, $email, $gender, $tFA, $_SESSION['username']);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $_SESSION['username'] = $username;
            setcookie("token","",time()-3600,"/");
            set_token_cookie($_SESSION['username'], $_SESSION['remember']);
            $query = "DELETE FROM topic_utente WHERE Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $query = "INSERT INTO topic_utente (Nome_tag_Topic, Username_Utente) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            foreach ($topic as $topic_name) {
                $stmt->bind_param("ss", $topic_name, $username);
                $success = $stmt->execute();
                if (!$success) {
                    throw new \Exception("Error while querying the database: " . mysqli_error($db));
                }
            }


        }

        public function update_password(string $password)
        {
            $hashedPassword =password_hash($password,PASSWORD_DEFAULT);
            $db = getDB();
            $query = "UPDATE utente SET Password = ? WHERE Username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ss", $hashedPassword, $_SESSION['username']);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

        }

        public function update_infos_profile(
            string $nome,
            string $cognome,
            string $username,
            string $data_nascita,
            string $email,
            string $foto_profilo,
            string $sesso,
            string $descrizione,
            string $foto_background,
            int $tFA
        ) {
            $db = getDB();
            $query = "UPDATE utente SET Nome = ?, Cognome = ?, Username = ?, Data_nascita = ?, Email = ?,foto_profilo = ?, 
                sesso = ?, descrizione = ?, foto_background = ?, 2FA = ? WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sssssbssbis", $nome, $cognome, $username, $data_nascita, $email, $foto_profilo, $sesso, $descrizione, $foto_background, $tFA, $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
        }

    }

    class UserUtility
    {
        public static function get_utente_by_username(string $username)
        {
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
                $user = new DBUtente(
                    $row["Nome"],
                    $row["Cognome"],
                    $row["Username"],
                    $row["Data_nascita"],
                    $row["Email"],
                    null,
                    $row["Foto_profilo"],
                    $row["Sesso"],
                    $row["Descrizione"],
                    $row["Foto_background"],
                    $row["2FA"],
                    $row["follower"],
                    $row["seguiti"]
                );
            } else {
                return null;
            }
            return $user;
        }
        

        public static function get_utente_by_email(string $email)
        {
            $db = getDB();
            $query = "SELECT * FROM utente WHERE email = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $email);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user = new DBUtente(
                    $row["nome"],
                    $row["cognome"],
                    $row["username"],
                    $row["data_nascita"],
                    $row["email"],
                    null,
                    $row["foto_profilo"],
                    $row["sesso"],
                    $row["descrizione"],
                    $row["foto_background"]
                );
            } else {
                return null;
            }
            return $user;

        }

        public static function search_users(string $search)
        {
            $db = getDB();
            $query = "SELECT * FROM utente WHERE Username LIKE ? ";
            $stmt = $db->prepare($query);
            $search = $search . "%";
            $stmt->bind_param("s", $search);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

            $result = $stmt->get_result();
            $users = array();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_array();
                    $user = new DBUtente(null, null, $row["Username"], null, null, null, $row["Foto_profilo"]);
                    array_push($users, $user);
                }
                return $users;
            } else {
                return null;
            }
        }



        public static function check_if_available($username = "", $email = ""): void
        {
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

        public static function retrieve_followed($username)
        {
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
                    $user = new DBUtente(
                        $row["nome"],
                        $row["cognome"],
                        $row["username"],
                        $row["data_nascita"],
                        $row["email"],
                        $row["password"],
                        $row["foto_profilo"],
                        $row["sesso"],
                        $row["descrizione"],
                        $row["foto_background"]
                    );
                    array_push($users, $user);
                }
            }
            return $users;
        }

        public static function get_topics_by_username(string $username){
            $db = getDB();
            $query="SELECT Nome_tag_Topic FROM topic_utente WHERE Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();
            $topics = [];
            while ($row = $result->fetch_assoc()) {
                array_push($topics, $row['Nome_tag_Topic']);
            }
            return $topics;
        }

        public static function retrieve_profile_photo($username)
        {
            $db = getDB();
            $query = "SELECT Foto_profilo FROM utente WHERE Username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["Foto_profilo"];
            } else {
                return null;
            }
        }

        public static function retrieve_background($username)
        {
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

        public static function retrieve_bio($username)
        {
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
        public static function retrieve_followers($username)
        {
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
                    $user = new DBUtente(
                        $row["nome"],
                        $row["cognome"],
                        $row["username"],
                        $row["data_nascita"],
                        $row["email"],
                        $row["password"],
                        $row["foto_profilo"],
                        $row["sesso"],
                        $row["descrizione"],
                        $row["foto_background"]
                    );
                    array_push($users, $user);
                }
            }
            return $users;
        }

        public static function retrieve_email($username)
        {
            $db = getDB();
            $query = "SELECT Email FROM utente WHERE Username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row["Email"];
            } else {
                return null;
            }
        }

        public static function insert_2FA($username, $code)
        {
            $db = getDB();
            $query = "SELECT username FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . mysqli_error($db));
            }

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $query = "UPDATE utente SET 2FA = ? WHERE username = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss", $code, $username);
                $success = $stmt->execute();
                if (!$success) {
                    throw new \Exception("Error while querying the database: " . mysqli_error($db));
                }
            } else {
                throw new \Exception("Error while querying the database: ");
            }
        }

        public static function retrieve_2FA($username)
        {
            $db = getDB();
            $query = "SELECT 2FA FROM utente WHERE username = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username);
            $success = $stmt->execute();
            if (!$success) {
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