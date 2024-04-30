<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDpost = $_GET['IDpost']; 
    $media = array();

    $media['data'] = PostUtility::get_foto_video_post_by_IDpost($IDpost);
    $media['type'] = "foto_video";
    if ($media['data'] == null) {
        $media['data'] = PostUtility::get_testo_post_by_IDpost($IDpost);
        $media['type'] = "testo";
    }
    if ($media['data'] == null) {
        $media['data'] = PostUtility::get_opzioni_post_by_IDpost($IDpost);
        $media['type'] = "survey";
    }
    
    header('Content-Type: application/json');
    echo json_encode($media, JSON_PRETTY_PRINT);
?>