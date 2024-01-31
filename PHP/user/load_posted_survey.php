<?php
    use post\PostUtility;
    
    $posts = PostUtility::get_posts_by_username_utente_survey($_SESSION['username']);
    header('Content-Type: application/json');
    echo json_encode($posts, JSON_PRETTY_PRINT);
?>