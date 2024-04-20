<?php
    use User\UserUtility;
    require_once '../Utils/bootstrap.php';
    require_once '../Utils/user.php';
    sec_session_start();
    header('Content-Type: application/json');
    $users = UserUtility::search_users($_POST['inputValue']);
    if ($users != null) {
        echo json_encode($users, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(array('error' => 'No users found'), JSON_PRETTY_PRINT);
    }
?>