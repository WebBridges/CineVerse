<?php
    use User\DBUtente;
    use User\UserUtility;
    require_once("../Utils/user.php");
    $followerCount = new DBUtente();
    $user = new UserUtility();
    $followerCount = $user::retrieve_followers($_POST['username']);
    echo json_encode(count($followerCount));
?>