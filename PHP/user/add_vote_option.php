<?php
    require_once("../Utils/post.php");
    use post\PostUtility;
    use post\DBVoto;

    $request = json_decode(file_get_contents('php://input'), true);
    $IDpost = $request['IDpost'];
    $option = $request['option'];
    $nVotes = PostUtility::get_number_of_votes_for_post_by_username($IDpost, $_SESSION['username']);
    if ($option["opzione"] == "radio" && $nVotes > 0) {
        PostUtility::remove_all_vote_by_IDpost_and_username($IDpost, $_SESSION['username']);
    }
    $vote = new DBVoto($IDpost, $_SESSION['username'], $option["testo"]);
    $vote->db_serialize();
    header('Content-Type: application/json');
    echo json_encode($vote, JSON_PRETTY_PRINT);
?>