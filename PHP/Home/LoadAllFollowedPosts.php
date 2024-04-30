<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    if(!isset($_GET['username'])) 
    { 
        $username = $_SESSION['username'];
    } else {
        $username = $_GET['username'];
    }

    $max_posts = $_GET['max_posts'];
    
    $posts = PostUtility::recent_posts_followed($username, $max_posts);
    
    header('Content-Type: application/json');
    echo json_encode($posts, JSON_PRETTY_PRINT);
?>