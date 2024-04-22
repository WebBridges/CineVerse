<?php
    require_once("../Utils/post.php");
    use Post\DBLike_commento;

    $request = json_decode(file_get_contents('php://input'), true);
    $IDcomment = $request['IDcomment'];
    $like = new DBLike_commento($IDcomment, $_SESSION['username']);
    $like->db_serialize();
    header('Content-Type: application/json');
    echo json_encode($like, JSON_PRETTY_PRINT);
?>