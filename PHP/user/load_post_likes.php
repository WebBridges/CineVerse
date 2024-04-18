<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDpost = $_GET['IDpost'];
    $nLikes = PostUtility::get_count_like_post_by_IDpost($IDpost);
    header('Content-Type: application/json');
    echo json_encode($nLikes, JSON_PRETTY_PRINT);
?>