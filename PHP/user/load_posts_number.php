<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $username = $_GET['username'];
    $nPosts = PostUtility::get_posts_number_by_username_utente($username);
    header('Content-Type: application/json');
    echo json_encode($nPosts, JSON_PRETTY_PRINT);
?>