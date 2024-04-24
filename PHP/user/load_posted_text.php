<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    if(!isset($_GET['username'])) 
    { 
        $username = $_SESSION['username'];
    } else {
        $username = $_GET['username'];
    }
    
    $posts = PostUtility::get_posts_by_username_utente_text($username);
    $texts = array();
    foreach($posts as $post) {
        $text = PostUtility::get_testo_post_by_IDpost($post->get_IDpost());
        if($text != null) {
            array_push($texts, $text);
        }
    }

    $merged = array_merge($posts, $texts);
    $mergedEncoded = json_encode($merged, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    echo $mergedEncoded;
?>