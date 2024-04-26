<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDpost = $_GET['IDpost'];
    $option = $_GET['option'];
    $nVotes = PostUtility::get_number_of_votes_for_option($IDpost, $option);
    header('Content-Type: application/json');
    echo json_encode($nVotes, JSON_PRETTY_PRINT);
?>