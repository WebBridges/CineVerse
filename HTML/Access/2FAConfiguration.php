<?php
    if(isset($_COOKIE['token'])) {
        header('Location: ../../HTML/Profile/userpage.php');
    }
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>CineVerse - Registrazione</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../../CSS/Access/AccessStyleBase.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid d-flex flex-column vh-100 justify-content-center align-items-center">
            <div>
                <div class="d-flex justify-content-center align-items-center">
                    <h1>CineVerse</h1>
                </div>
                <div id="ContentBlock">
                    <div id="MainBlock" class="col-12 d-flex flex-column align-items-center pb-4">
                        <div id="BlockBanner" class="d-flex justify-content-center align-items-center w-100">
                            2FA Configuration
                        </div>
                        <div>
                            <div class="mt-4">
                                <p>Attivare l'autenticazione a 2 fattori?</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                <button id="Process" class="btn btn-primary me-4">Procedere</button>
                                <button id="Deny" class="btn btn-secondary" onclick="location.href='LoginPage.html'">No grazie</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../JAVASCRIPT/Access/2FA.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>