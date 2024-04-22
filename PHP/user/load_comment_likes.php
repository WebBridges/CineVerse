<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDcomment = $_GET['IDcomment'];
    $nLikes = PostUtility::get_count_like_commento_by_IDcommento($IDcomment);
    header('Content-Type: application/json');
    echo json_encode($nLikes, JSON_PRETTY_PRINT);
?>