<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDpost = $_GET['IDpost'];
    if (!isset($username)) {
        $username = $_SESSION['username'];
    } else {
        $username = $_GET['username'];
    }
    $liked = PostUtility::check_like_post($IDpost, $username);
    header('Content-Type: application/json');
    echo json_encode($liked, JSON_PRETTY_PRINT);
?>