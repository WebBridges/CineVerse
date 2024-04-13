<?php
$servername = "sql11.freesqldatabase.com";
$username = "sql11698630";
$password = "D8iesRmkrX";
$database = "sql11698630";

$username_utente = "bacco";

// Create connection
$conn = new mysqli($servername, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_errno) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$query = "SELECT * FROM post WHERE Username_Utente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username_utente);
$success = $stmt->execute();
if (!$success) {
    throw new \Exception("Error while querying the database: " . $stmt->error);
}

/*$result = $stmt->get_result();
if ($result->num_rows > 0) {
    for ($i = 0; $i < $result->num_rows; $i++) {
        $row = $result->fetch_assoc();
        printf("Titolo: %s, IDpost: %s, Archiviato: %s, Username_Utente: %s, Nome_tag_Topic: %s\n", $row["Titolo"], $row["IDpost"], $row["Archiviato"], $row["Username_Utente"], $row["Nome_tag_Topic"]);
    }
}*/


require_once("../../PHP/Utils/post.php");
use post\PostUtility;

$posts = PostUtility::get_posts_by_username_utente_foto_video("bacco"/*$_SESSION['username']*/);
$photos = array();
foreach($posts as $post) {
    $photo = PostUtility::get_foto_video_post_by_IDpost($post->get_IDpost());
    if($photo != null) {
        array_push($photos, $photo);
    }
}
$merged = array_merge($posts, $photos);
$mergedEncoded = json_encode($merged, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $mergedEncoded;
?>