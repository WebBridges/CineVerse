<?php
    require_once("../Bootstrap.php");
    if($db->check2FA_Active()==true){
        header("location: ../2FA_Login.html");
    }
    else{header("Location: ../userpage.html");}
?>