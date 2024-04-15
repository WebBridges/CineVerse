<?php
    session_unset();
    setcookie('token', '', time() - 3600, '/');
    header('Location: ../../HTML/Access/AccessPage.html');
    exit();
?>
