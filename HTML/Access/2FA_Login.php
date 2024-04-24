<?php
    if(isset($_COOKIE['token'])) {
        header('Location: ../../HTML/Profile/userpage.php');
    }
?>


<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>CineVerse - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../../CSS/Access/AccessStyleBase.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid d-flex vh-100 justify-content-center align-items-center">
            <div>
                <div class="d-flex justify-content-center align-items-center">
                    <h1>CineVerse</h1>
                </div>
                
                <div id="MainBlock" class="col-12 flex-column justify-content-center align-items-center mb-3">
                    <div id="BlockBanner" class="w-100 d-flex justify-content-center align-items-center">
                        2FA Verification
                    </div>
                    <div class="mt-4 text-center">
                        <p>Inserire il codice inviato alla tua mail:</p>
                    </div>
                    <form id="2FA_Form" class="mt-1 mb-2" action="../../PHP/Access/Process2FA_login.php" method="POST" novalidate>
                        <div class="d-flex justify-content-center">
                            <div class="col-9 mt-1 py-3">
                                <input type="text" class="form-control py-2" name="2fa" id="2fa" value="" maxlength="10" placeholder="codice" required>
                                <div class="invalid-feedback">
                                    Please provide a valid code
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="error-message" class="error-message d-none"></div>
                    <div class="d-flex justify-content-center mb-4">
                        <button id="resend" class="btn btn-secondary mb-4 me-4">Rinvia codice</button>
                        <button id="submit" class="btn btn-primary mb-4" type="submit" form="2FA_Form">Verifica</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../JAVASCRIPT/Access/Login2FA.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>