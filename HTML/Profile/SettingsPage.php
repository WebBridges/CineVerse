<?php
    include '../../PHP/Utils/auth_request.php';
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>CineVerse - Impostazioni</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../../CSS/Access/AccessStyleBase.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-4">
            
                <div class="justify-content-center align-items-center">
                    <h1>CineVerse</h1>
                </div>
                
                <div id="MainBlock" class="col-8">
                    <div id="BlockBanner" class="col-12 d-flex flex-column justify-content-center align-items-center text-center ">
                        Impostazioni Account
                    </div>
                    <form id="FormRegistration" action="" method="POST" novalidate>
                        <div class="row container-fluid">
                            <div class="col-md-6  mb-2 d-flex flex-column justify-content-center align-items-center">
                                <div class="col-8 mt-2">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nome</label>
                                        <input type="text" class="form-control" name="name" id="name" value="" maxlength="30" placeholder="Nome" required>
                                    </div>
                                </div> 
                                <div class="col-8 mt-2">
                                    <div class="form-group">
                                        <label for="surname" class="form-label">Cognome</label>
                                        <input type="text" class="form-control" name="surname" id="surname" value="" maxlength="30" placeholder="Cognome" required>
                                    </div>
                                </div>  
                                <div class="col-8 mb-md-4 mt-2">
                                    <div class="form-group">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" value="" maxlength="30" placeholder="Username" required>
                                    </div>
                                </div>         
                            </div>
                            <div class="col-md-6 mb-2  d-flex flex-column justify-content-center align-items-center">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="" maxlength="50" placeholder="Email" required>
                                    </div>
                                </div>  
                                <div class="col-8 mt-2">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" value="" maxlength="30" placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="col-8 mt-2 justify-content-center pt-4">
                                    <div class="form-group d-flex align-items-center">
                                        <label for="twoFactorAuth" class="form-label">Autenticazione a 2 Fattori</label>
                                        <label class="switch" for="checkbox">
                                            <input type="checkbox" id="checkboxTFA" />
                                            <div class="slider round"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row container-fluid ">
                            <div class="col-md-6  mb-md-4 d-flex flex-column">
                                <div class="form-group">
                                    <p class="offset-2">genere (opzionale):</p>
                                    <div class="col-md-8 ms-5">
                                        <div class="form-check col-8 offset-1 offset-md-2">
                                            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                            <label class="form-check-label" for="male">
                                                Maschio
                                            </label>
                                        </div>
                                        <div class="form-check col-8 offset-1 offset-md-2">
                                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                            <label class="form-check-label" for="female">
                                                Femmina
                                            </label>
                                        </div>
                                        <div class="form-check col-8 offset-1 offset-md-2">
                                            <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                                            <label class="form-check-label" for="other">
                                                Altro
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9 mt-2 ms-3 ms-md-4">
                                    <div class="col-8 offset-1 offset-md-2">
                                        <div class="form-group">
                                            <label for="birthdate" class="form-label">Data di nascita</label>
                                            <input type="date" class="form-control" name="birthDate" id="birthDate" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 d-flex  flex-column justify-content-center align-items-center">
                                <div class="form-group">
                                    <div>
                                        <p class="mt-md-0 mt-3 offset-2">Lista dei topic disponibili (massimo 5):</p>
                                    </div>
                                    <div id="TopicList" class="col-9 offset-2" style="max-height: 170px; overflow-y: auto; display: flex; flex-wrap: wrap;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row container-fluid text-left">
                            <div class="col-12 mb-2 d-flex flex-column justify-content-center align-items-center text-center">
                                <div class="form-group" style="color:#8B0000;" >
                                    <div id="errorName" class="error-message" style="display: none;">
                                        Il nome non deve contenere caratteri speciali o numeri
                                    </div>
                                    <div id="errorSurname" class="mt-1 mb-1 error-message" style="display: none;">
                                        Il cognome non deve contenere caratteri speciali o numeri
                                    </div>
                                    <div id="usernameSpecialChar" class="mt-1 mb-1 error-message" style="display:none;">
                                        Lo username non deve contenere caratteri speciali (esclusi numeri e _)
                                    </div>
                                    <div id="usernameNotAvaible" class="mt-1 mb-1 error-message" style="display: none;">
                                        Lo username non è disponibile
                                    </div>
                                    <div id="errorEmail" class="mt-1 mb-1 error-message" style="display: none;">
                                        inserire un'email valida
                                    </div>
                                    <div id="passwordLength" class="mt-1 mb-1 error-message" style="display: none;">
                                        La password deve contenere almeno 8 caratteri.
                                    </div>
                                    <div id="passwordSpecialChar" class="mt-1 mb-1 error-message" style="display: none;">
                                        La password può contenere solo lettere, numeri, spazi, e i caratteri _!@#$%^*.
                                    </div>
                                    <div id="errorAge" class="mt-1 mb-1 error-message" style="display: none;">
                                        L'età minima per registrarsi è di 14 anni
                                    </div>
                                    <div id="errorTopic" class="mt-1 mb-1 error-message" style="display: none;">
                                        Seleziona minimo due topic
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6 mb-4 mt-2 d-flex justify-content-center">
                                <button class="btn btn-primary" type="submit">Salva modifiche</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>

        <script src="../../JAVASCRIPT/Access/RegistrationFunction.js"></script>
        <script src="../../JAVASCRIPT/Access/ValidateForm.js"></script>
        <script src="../../JAVASCRIPT/Profile/SettingsPage.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>