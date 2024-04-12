<?php
    session_unset();
    unset($_COOKIE['token']);
    header('Location: ../../HTML/Access/AccessPage.html');
    exit();
?>