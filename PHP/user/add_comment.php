<?php
    require_once("../Utils/post.php");
    use Post\DBCommento;

    $request = json_decode(file_get_contents('php://input'), true);
    $IDpost = $request['IDpost'];
    $commentText = $request['commentText'];
    $comment = new DBCommento($commentText, null, $IDpost, $_SESSION['username'], null);
    $comment->db_serialize();
    header('Content-Type: application/json');
    echo json_encode($comment, JSON_PRETTY_PRINT);


?>