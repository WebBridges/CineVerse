<?php
    use User\UserUtility;
    require_once '../Utils/bootstrap.php';
    require_once '../Utils/user.php';
    sec_session_start();
    header('Content-Type: application/json');
    $user = UserUtility::get_utente_by_username($_POST['username']);
    $user->set_topics(UserUtility::get_topics_by_username($_POST['username']));
    echo json_encode($user, JSON_PRETTY_PRINT);
?>