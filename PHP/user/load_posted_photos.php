<?php
    require_once("../Utils/post.php");
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