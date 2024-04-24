<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    if(!isset($_GET['username'])) 
    { 
        $username = $_SESSION['username'];
    } else {
        $username = $_GET['username'];
    }
    
    $posts = PostUtility::get_posts_by_username_utente_survey($username);
    $options = array();
    foreach($posts as $post) {
        $option = PostUtility::get_opzioni_post_by_IDpost($post->get_IDpost());
        if($option != null) {
            $options[$post->get_IDpost()] = $option;
        }
    }

    $merged["posts"] = $posts;
    $merged["options"] = $options;
    $mergedEncoded = json_encode($merged, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    echo $mergedEncoded;
?>
