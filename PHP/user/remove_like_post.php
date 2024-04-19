<?php
    require_once("../Utils/post.php");
    use post\DBLike_post;

    $request = json_decode(file_get_contents('php://input'), true);
    $IDpost = $request['IDpost'];
    $like = new DBLike_post($IDpost, $_SESSION['username']);
    $like->db_delete();
    header('Content-Type: application/json');
    echo json_encode($like, JSON_PRETTY_PRINT);
?>