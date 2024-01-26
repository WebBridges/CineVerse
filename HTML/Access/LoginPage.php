<?php
    include "../Bootstrap.php";
    if(isset($_SESSION['email']) || isset($_COOKIE['email'])){
        header("Location: ../userpage.html");
    } else if(isset($_COOKIE['email'])){
        $_SESSION['email'] = $_COOKIE['email'];
        header("Location: ../userpage.html");
    }
?>


<!DOCTYPE html>

<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>CineVerse - Login</title>
        <link href="css/AccessStyleBase.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <main>
            <section>
                <h1>CineVerse</h1>
                <h2>Login</h2>
                <form id="loginForm" action="template/ProcessLogin.php" method="post">
                    <fieldset id="LoginInfo">
                        <ul>
                            <li>
                                <label for="Email">Email</label>
                                <input type="email" name="email" id="email" maxlength="50" placeholder="email" required>
                            </li>
                            <li>
                                <label for="Password">Password</label>
                                <input type="password" name="password" id="password" maxlength="30" placeholder="password" required>
                            </li>
                            <li>
                                <input type="submit" value="Access" id="LoginButton" class="buttonOrange">
                            </li>
                        </ul>
                    </fieldset>
                </form>
                <li><a href="google.html">Continua con Google</a><br/></li>
                <li><a href="recuperopassword.html"> Hai dimenticato la password? Clicca qui </a></li>
            </section>
        </main>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="JAVASCRIPT/Access/Login.js" type="text/javascript"></script>
    </body>
</html>