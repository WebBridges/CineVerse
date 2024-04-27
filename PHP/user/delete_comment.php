<?php
    require_once("../Utils/post.php");
    use Post\PostUtility;

    $IDcomment = $_GET['IDcomment'];
    $result = PostUtility::delete_comment_by_IDcommento($IDcomment);
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
?>