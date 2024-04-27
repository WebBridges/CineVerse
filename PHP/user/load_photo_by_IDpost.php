<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDpost = $_GET['IDpost'];
    $photo = PostUtility::get_foto_video_post_by_IDpost($IDpost);

    header('Content-Type: application/json');
    echo json_encode($photo, JSON_PRETTY_PRINT);
?>