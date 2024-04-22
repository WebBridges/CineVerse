<?php
    use User\DBUtente;
    use User\UserUtility;
    require_once("../Utils/bootstrap.php");
    require_once("../Utils/user.php");
    sec_session_start();

    $usersFollowed= new DBUtente();
    $user = new UserUtility();
    $usersFollowed = $user::retrieve_followed($_SESSION['username']);
    if(count($usersFollowed) > 0){
        foreach ($usersFollowed as $followedUser) {
            if ($followedUser instanceof DBUtente) {
                if ($followedUser->get_username() === $_POST['usernameURL']) {
                    echo json_encode(true);
                    break;
                }
            }
        }
        echo json_encode(false);
    } else {
        echo json_encode(false);
    }
?>