<?php
    if(isset($_COOKIE['token'])) {
        header('Location: ../../HTML/Profile/userpage.php');
    }
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>CineVerse</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../../CSS/Access/AccessStyleBase.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid vh-100 d-flex justify-content-center align-items-center ">
            <div>
                <div class="d-flex justify-content-center align-items-center">
                    <h1>CineVerse</h1>
                </div>
                
                <div id="MainBlock" class=" col-12 container d-flex flex-column justify-content-center align-items-center mt-3 mb-3">
                    <div class="col-12 mt-5 mb-2 d-flex justify-content-center">
                        <a href="LoginPage.html" class="btn btn-primary mb-2">Accedi</a>
                    </div>
                    <div class="col-12 mb-5 d-flex justify-content-center">
                        <a href="RegistrationPage.html" class="btn btn-secondary">Registrati</a>
                    </div>
                </div>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>