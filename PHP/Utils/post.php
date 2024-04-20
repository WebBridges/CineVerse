<?php

namespace Post {

    require_once("bootstrap.php");
    require_once("dbObject.php");

    class DBPost implements \DBObject
    {
        private $titolo;
        private $IDpost;
        private $archiviato;
        private $username_utente;
        private $nome_tag_topic;
        public function __construct($titolo = null, $IDpost = null, $archiviato = null, $username_utente = null, $nome_tag_topic = null)
        {
            $this->titolo = $titolo;
            $this->IDpost = $IDpost;
            $this->archiviato = $archiviato;
            $this->username_utente = $username_utente;
            $this->nome_tag_topic = $nome_tag_topic;
        }

        public function jsonSerialize()
        {
            return [
                "titolo" => $this->titolo,
                "IDpost" => $this->IDpost,
                "archiviato" => $this->archiviato,
                "username_utente" => $this->username_utente,
                "nome_tag_topic" => $this->nome_tag_topic
            ];
        }

        public function get_titolo()
        {
            return $this->titolo;
        }

        public function get_IDpost()
        {
            return $this->IDpost;
        }

        public function get_archiviato()
        {
            return $this->archiviato;
        }

        public function get_username_utente()
        {
            return $this->username_utente;
        }

        public function get_nome_tag_topic()
        {
            return $this->nome_tag_topic;
        }

        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO post (Titolo, Archiviato, Username_utente, Nome_tag_topic) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("siss", $this->titolo, $this->archiviato, $this->username_utente, $this->nome_tag_topic);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }
    }

    class DBCommento implements \DBObject
    {
        private $corpo;
        private $IDcommento;
        private $IDpost;
        private $username_utente;
        private $IDcommento_padre;

        public function __construct($corpo = null, $IDcommento = null, $IDpost = null, $username_utente = null, $IDcommento_padre = null)
        {
            $this->corpo = $corpo;
            $this->IDcommento = $IDcommento;
            $this->IDpost = $IDpost;
            $this->username_utente = $username_utente;
            $this->IDcommento_padre = $IDcommento_padre;
        }

        public function jsonSerialize()
        {
            return [
                "corpo" => $this->corpo,
                "IDcommento" => $this->IDcommento,
                "IDpost" => $this->IDpost,
                "username_utente" => $this->username_utente,
                "IDcommento_padre" => $this->IDcommento_padre
            ];
        }

        public function get_corpo()
        {
            return $this->corpo;
        }

        public function get_IDcommento()
        {
            return $this->IDcommento;
        }

        public function get_IDpost()
        {
            return $this->IDpost;
        }

        public function get_username_utente()
        {
            return $this->username_utente;
        }

        public function get_IDcommento_padre()
        {
            return $this->IDcommento_padre;
        }

        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO commento (Corpo, IDpost, Username_utente, IDcommento_padre) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sisi", $this->corpo, $this->IDpost, $this->username_utente, $this->IDcommento_padre);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }
    }

    class DBLike_post implements \DBObject
    {
        private $IDpost;
        private $username_utente;

        public function __construct($IDpost = null, $username_utente = null)
        {
            $this->IDpost = $IDpost;
            $this->username_utente = $username_utente;
        }

        public function jsonSerialize()
        {
            return [
                "IDpost" => $this->IDpost,
                "username_utente" => $this->username_utente
            ];
        }

        public function get_IDpost()
        {
            return $this->IDpost;
        }

        public function get_username_utente()
        {
            return $this->username_utente;
        }

        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO like_post (IDpost, Username_Utente) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $this->IDpost, $this->username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }

        public function db_delete()
        {
            $db = getDB();
            $query = "DELETE FROM like_post WHERE IDpost = ? AND Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $this->IDpost, $this->username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }
    }

    class DBLike_commento implements \DBObject
    {
        private $IDcommento;
        private $username_utente;

        public function __construct($IDcommento = null, $username_utente = null)
        {
            $this->IDcommento = $IDcommento;
            $this->username_utente = $username_utente;
        }

        public function jsonSerialize()
        {
            return [
                "IDcommento" => $this->IDcommento,
                "username_utente" => $this->username_utente
            ];
        }

        public function get_IDcommento()
        {
            return $this->IDcommento;
        }

        public function get_username_utente()
        {
            return $this->username_utente;
        }

        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO like_commento (IDcommento, Username_utente) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $this->IDcommento, $this->username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }

        public function db_delete()
        {
            $db = getDB();
            $query = "DELETE FROM like_commento WHERE IDcommento = ? AND Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $this->IDcommento, $this->username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }
    }

    class DBOpzione implements \DBObject
    {
        private $IDpost;
        private $testo;

        public function __construct($IDpost = null, $testo = null)
        {
            $this->IDpost = $IDpost;
            $this->testo = $testo;
        }

        public function jsonSerialize()
        {
            return [
                "IDpost" => $this->IDpost,
                "testo" => $this->testo
            ];
        }

        public function get_IDpost()
        {
            return $this->IDpost;
        }

        public function get_testo()
        {
            return $this->testo;
        }

        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO opzione (IDpost, Testo) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $this->IDpost, $this->testo);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }
    }

    class DBVoto implements \DBObject
    {
        private $username_utente;
        private $IDpost;
        private $testo_opzione;

        public function __construct($IDpost = null, $username_utente = null, $testo_opzione = null)
        {
            $this->IDpost = $IDpost;
            $this->username_utente = $username_utente;
            $this->testo_opzione = $testo_opzione;
        }

        public function jsonSerialize()
        {
            return [
                "IDpost" => $this->IDpost,
                "username_utente" => $this->username_utente,
                "testo_opzione" => $this->testo_opzione
            ];
        }

        public function get_username_utente()
        {
            return $this->username_utente;
        }

        public function get_IDpost()
        {
            return $this->IDpost;
        }

        public function get_testo_opzione()
        {
            return $this->testo_opzione;
        }
        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO voto (IDpost, Username_utente, testo_opzione) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("isi", $this->IDpost, $this->username_utente, $this->testo_opzione);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }

        public function db_delete()
        {
            $db = getDB();
            $query = "DELETE FROM voto WHERE IDpost = ? AND Username_utente = ? AND testo_opzione = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("iss", $this->IDpost, $this->username_utente, $this->testo_opzione);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
        }
    }

    class DBTesto implements \DBObject
    {
        private $IDpost_testo;
        private $IDpost;
        private $corpo;

        public function __construct($IDpost_testo = null, $IDpost = null, $corpo = null)
        {
            $this->IDpost_testo = $IDpost_testo;
            $this->IDpost = $IDpost;
            $this->corpo = $corpo;
        }

        public function jsonSerialize()
        {
            return [
                "IDpost_testo" => $this->IDpost_testo,
                "IDpost" => $this->IDpost,
                "corpo" => $this->corpo
            ];
        }

        public function get_IDpost_testo()
        {
            return $this->IDpost_testo;
        }

        public function get_IDpost()
        {
            return $this->IDpost;
        }

        public function get_corpo()
        {
            return $this->corpo;
        }

        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO testo (IDpost, Corpo) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $this->IDpost, $this->corpo);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $this->IDpost_testo = $db->insert_id;
        }
    }

    class DBFoto_video implements \DBObject
    {
        private $IDpost_foto_video;
        private $IDpost;
        private $foto_video;
        private $descrizione;

        public function __construct($IDpost_foto_video = null, $IDpost = null, $foto_video = null, $descrizione = null)
        {
            $this->IDpost_foto_video = $IDpost_foto_video;
            $this->IDpost = $IDpost;
            $this->foto_video = $foto_video;
            $this->descrizione = $descrizione;
        }

        public function jsonSerialize()
        {
            return [
                "IDpost_foto_video" => $this->IDpost_foto_video,
                "IDpost" => $this->IDpost,
                "foto_video" => $this->foto_video,
                "descrizione" => $this->descrizione
            ];
        }

        public function get_IDpost_foto_video()
        {
            return $this->IDpost_foto_video;
        }

        public function get_IDpost()
        {
            return $this->IDpost;
        }

        public function get_foto_video()
        {
            return $this->foto_video;
        }

        public function get_descrizione()
        {
            return $this->descrizione;
        }

        public function db_serialize()
        {
            $db = getDB();
            $query = "INSERT INTO foto_video (IDpost, Foto_Video, Descrizione) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("iss", $this->IDpost, $this->foto_video, $this->descrizione);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $this->IDpost_foto_video = $db->insert_id;
        }
    }

    class PostUtility
    {
        public static function get_post_by_IDpost($idpost)
        {
            $db = getDB();
            $query = "SELECT * FROM post WHERE IDpost = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $idpost);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return new DBPost(
                $row["Titolo"],
                $row["IDpost"],
                $row["Archiviato"],
                $row["Username_Utente"],
                $row["Nome_tag_Topic"]
            );
        }

        public static function get_posts_number_by_username_utente($username_utente)
        {
            $db = getDB();
            $query = "SELECT COUNT(*) AS count FROM post WHERE Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return $row["count"];
        }

        public static function get_all_posts_by_username_utente($username_utente)
        {
            $db = getDB();
            $query = "SELECT * FROM post WHERE Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $posts = array();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $post = new DBPost(
                        $row["Titolo"],
                        $row["IDpost"],
                        $row["Archiviato"],
                        $row["Username_Utente"],
                        $row["Nome_tag_Topic"]
                    );
                    array_push($posts, $post);
                }
            }
            return $posts;
        }

        /**
         * return post by username_utente that only are foto_video posts
         */
        public static function get_posts_by_username_utente_foto_video($username_utente)
        {
            $db = getDB();
            $query = "SELECT * FROM post WHERE Username_Utente = ? AND IDpost IN (SELECT IDpost FROM foto_video)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
            $posts = array();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $post = new DBPost(
                        $row["Titolo"],
                        $row["IDpost"],
                        $row["Archiviato"],
                        $row["Username_Utente"],
                        $row["Nome_tag_Topic"]
                    );
                    array_push($posts, $post);
                }
            }
            return $posts;
        }

        /**
         * return post by username_utente that only are textual posts
         */
        public static function get_posts_by_username_utente_text($username_utente)
        {
            $db = getDB();
            $query = "SELECT * FROM post WHERE Username_Utente = ? AND IDpost IN (SELECT IDpost FROM testo)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
            $posts = array();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $post = new DBPost(
                        $row["Titolo"],
                        $row["IDpost"],
                        $row["Archiviato"],
                        $row["Username_Utente"],
                        $row["Nome_tag_Topic"]
                    );
                    array_push($posts, $post);
                }
            }
            return $posts;
        }

        /**
         * return post by username_utente that only are survey posts
         */
        public static function get_posts_by_username_utente_survey($username_utente)
        {
            $db = getDB();
            $query = "SELECT * FROM post WHERE Username_Utente = ? AND IDpost IN (SELECT DISTINCT IDpost FROM opzione)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("s", $username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
            $posts = array();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $post = new DBPost(
                        $row["Titolo"],
                        $row["IDpost"],
                        $row["Archiviato"],
                        $row["Username_Utente"],
                        $row["Nome_tag_Topic"]
                    );
                    array_push($posts, $post);
                }
            }
            return $posts;
        }

        public static function get_foto_video_post_by_IDpost($idpost)
        {
            $db = getDB();
            $query = "SELECT * FROM foto_video WHERE IDpost = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $idpost);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return new DBFoto_video(
                $row["IDpost_foto_video"],
                $row["IDpost"],
                $row["Foto_Video"],
                $row["Descrizione"]
            );
        }

        public static function get_testo_post_by_IDpost($idpost)
        {
            $db = getDB();
            $query = "SELECT * FROM testo WHERE IDpost = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $idpost);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return new DBTesto(
                $row["IDpost_testo"],
                $row["IDpost"],
                $row["Corpo"]
            );
        }

        public static function get_opzioni_post_by_IDpost($idpost)
        {
            $db = getDB();
            $query = "SELECT * FROM opzione WHERE IDpost = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $idpost);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $opzioni = array();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $opzione = new DBOpzione(
                        $row["IDpost"],
                        $row["Testo"]
                    );
                    array_push($opzioni, $opzione);
                }
            }
            return $opzioni;
        }

        public static function recent_posts_followed($username, $max_posts)
        {
            $db = getDB();
            $query = "SELECT P.*
                    FROM post P
                    WHERE P.username IN (
                        SELECT R.Username_Seguito
                        FROM relazione R
                        WHERE R.Username_Segue = ?)
                    ORDER BY P.posted DESC
                    LIMIT ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("si", $username, $max_posts);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $posts = array();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_array();
                    $post = new DBPost(
                        $row["Titolo"],
                        $row["IDpost"],
                        $row["Archiviato"],
                        $row["Username_Utente"],
                        $row["Nome_tag_Topic"]
                    );
                    array_push($posts, $post);
                }
            }
            return $posts;
        }

        public static function get_comments_by_IDpost($idpost)
        {
            $db = getDB();
            $query = "SELECT * FROM commento WHERE IDpost = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $idpost);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $comments = array();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_assoc();
                    $comment = new DBCommento(
                        $row["Corpo"],
                        $row["IDcommento"],
                        $row["IDpost"],
                        $row["Username_Utente"],
                        $row["IDcommento_padre"]
                    );
                    array_push($comments, $comment);
                }
            }
            return $comments;
        }

        public static function get_voto_by_username($username_utente, $IDpost, $testo_opzione)
        {
            $db = getDB();
            $query = "SELECT * FROM voto WHERE Username_utente = ? AND IDpost = ? AND testo_opzione = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sis", $username_utente, $IDpost, $testo_opzione);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return new DBVoto(
                $row["IDpost"],
                $row["Username_utente"],
                $row["testo_opzione"]
            );
        }

        public static function get_count_opzione_by_IDpost($IDpost, $testo_opzione)
        {
            $db = getDB();
            $query = "SELECT COUNT(*) AS count FROM voto WHERE IDpost = ? AND testo_opzione = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $IDpost, $testo_opzione);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return $row["count"];
        }

        public static function get_count_like_post_by_IDpost($IDpost)
        {
            $db = getDB();
            $query = "SELECT COUNT(*) AS count FROM like_post WHERE IDpost = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $IDpost);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return $row["count"];
        }

        public static function get_count_like_commento_by_IDcommento($IDcommento)
        {
            $db = getDB();
            $query = "SELECT COUNT(*) AS count FROM like_commento WHERE IDcommento = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $IDcommento);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return null;
            }
            $row = $result->fetch_assoc();
            return $row["count"];
        }

        public static function check_like_post($IDpost, $username_utente)
        {
            $db = getDB();
            $query = "SELECT * FROM like_post WHERE IDpost = ? AND Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $IDpost, $username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return false;
            }
            return true;
        }

        public static function check_like_commento($IDcommento, $username_utente)
        {
            $db = getDB();
            $query = "SELECT * FROM like_commento WHERE IDcommento = ? AND Username_Utente = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $IDcommento, $username_utente);
            $success = $stmt->execute();
            if (!$success) {
                throw new \Exception("Error while querying the database: " . $stmt->error);
            }
            $result = $stmt->get_result();
            if ($result->num_rows == 0) {
                return false;
            }
            return true;
        }

        /**
         * mancano le query per inserire e archiviare i post e inserire i commenti
         */





        /*public static function comments_with_post(\DBDriver $driver, $post_id, $username)
        {
            $sql = "SELECT C.*, U.profile_photo
                    FROM comment C, user U
                    WHERE C.post_id = ?
                    AND C.username = U.username";
            try {
                $result = $driver->query($sql, $post_id);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
            $comments = array();
            if ($result->num_rows > 0) {
                for ($i = 0; $i < $result->num_rows; $i++) {
                    $row = $result->fetch_array();
                    $sql = "SELECT * FROM comment_like WHERE comment_id = ? AND username = ?";
                    try {
                        $liked = $driver->query($sql, $row["comment_id"], $username)->num_rows > 0;
                    } catch (\Exception $e) {
                        throw new \Exception("Error while querying the database: " . $e->getMessage());
                    }
                    $owner = false;
                    $sql = "SELECT * FROM post WHERE post_id = ? AND username = ?";
                    try {
                        $owner = $driver->query($sql, $post_id, $username)->num_rows > 0;
                    } catch (\Exception $e) {
                        throw new \Exception("Error while querying the database: " . $e->getMessage());
                    }
                    if (!$owner) {
                        $owner = $row["username"] == $username;
                    }
                    $comment = new DBComment(
                        $row["comment_id"],
                        $row["post_id"],
                        $row["username"],
                        $row["profile_photo"],
                        $row["content"],
                        $row["likes"],
                        $liked,
                        $owner
                    );
                    array_push($comments, $comment);
                }
            }
            return $comments;
        }*/
        /*
        public static function insert_comment(\DBDriver $driver, $post_id, $username, $content)
        {
            $comment = new DBComment(null, $post_id, $username, null, $content);
            $comment->db_serialize($driver);
        }

        public static function delete_comment(\DBDriver $driver, $comment_id)
        {
            $com = new DBComment($comment_id);
            $com->db_delete($driver);
        }

        public static function insert_like(\DBDriver $driver, $like_id, $username, $type)
        {
            $sql = "UPDATE";
            try {
                switch ($type) {
                    case "post":
                        $like = new DBPostLike($like_id, $username);
                        $like->db_serialize($driver);
                        $sql = $sql . " post SET likes = likes + 1 WHERE post_id = ?";
                        break;
                    case "comment":
                        $like = new DBCommentLike($like_id, $username);
                        $like->db_serialize($driver);
                        $sql = $sql . " comment SET likes = likes + 1 WHERE comment_id = ?";
                        break;
                    default:
                        throw new \Exception("Invalid type: " . $type);
                }
                $driver->query($sql, $like_id);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
        }

        public static function delete_like(\DBDriver $driver, $like_id, $username, $type)
        {
            $sql = "UPDATE";
            try {
                switch ($type) {
                    case "post":
                        $like = new DBPostLike($like_id, $username);
                        $like->db_delete($driver);
                        $sql = $sql . " post SET likes = likes - 1 WHERE post_id = ?";
                        break;
                    case "comment":
                        $like = new DBCommentLike($like_id, $username);
                        $like->db_delete($driver);
                        $sql = $sql . " comment SET likes = likes - 1 WHERE comment_id = ?";
                        break;
                    default:
                        throw new \Exception("Invalid type: " . $type);
                }
                $driver->query($sql, $like_id);
            } catch (\Exception $e) {
                throw new \Exception("Error while querying the database: " . $e->getMessage());
            }
        }*/
    }
}
?>