<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDpost = $_GET['IDpost'];
    $nVotes = PostUtility::get_number_of_votes_by_IDpost($IDpost);
    header('Content-Type: application/json');
    echo json_encode($nVotes, JSON_PRETTY_PRINT);
?>