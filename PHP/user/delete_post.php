<?php
    require_once("../Utils/post.php");
    use Post\PostUtility;

    $IDpost = $_GET['IDpost'];
    $result = PostUtility::delete_post_by_IDpost($IDpost);
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
?>