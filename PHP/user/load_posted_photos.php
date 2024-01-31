<?php
    require_once("../Utils/post.php");
    use post\PostUtility;
    
    $posts = PostUtility::get_posts_by_username_utente_foto_video("bacco"/*$_SESSION['username']*/);
    header('Content-Type: application/json');
    echo json_encode($posts, JSON_PRETTY_PRINT);
?>