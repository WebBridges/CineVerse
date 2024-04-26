<?php
    require_once("../Utils/post.php");
    use post\DBVoto;

    $request = json_decode(file_get_contents('php://input'), true);
    $IDpost = $request['IDpost'];
    $option = $request['option'];
    $vote = new DBVoto($IDpost, $_SESSION['username'], $option["testo"]);
    $vote->db_delete();
    header('Content-Type: application/json');
    echo json_encode($vote, JSON_PRETTY_PRINT);
?>