<?php
    require_once("../Utils/post.php");
    use post\PostUtility;

    $IDpost = $_GET['IDpost'];
    $option = $_GET['option'];
    if (!isset($username)) {
        $username = $_SESSION['username'];
    } else {
        $username = $_GET['username'];
    }
    $voted = PostUtility::check_vote($IDpost, $option, $username);
    header('Content-Type: application/json');
    echo json_encode($voted, JSON_PRETTY_PRINT);
?>