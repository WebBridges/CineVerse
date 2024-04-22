<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDcomment = $_GET['IDcomment'];
    if (!isset($username)) {
        $username = $_SESSION['username'];
    } else {
        $username = $_GET['username'];
    }
    $liked = PostUtility::check_like_comment($IDcomment, $username);
    header('Content-Type: application/json');
    echo json_encode($liked, JSON_PRETTY_PRINT);
?>