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
        <link href="../../CSS/Access/AccessStyleBase.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center mt-4">
            
                <div class="justify-content-center align-items-center">
                    <h1>CineVerse</h1>
                </div>

                <div id="MainBlock" class="col-lg-7 col-11 col-md-10">
                    <div id="BlockBanner" class="col-12 d-flex flex-column justify-content-center align-items-center text-center ">
                        Impostazioni Profilo
                    </div>
                    <form id="FormRegistration" action="../../PHP/Profile/UpdateProfile.php" method="POST" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-4 d-flex mt-3 flex-column justify-content-center align-items-center">
                                <div class="form-group">
                                    <div>
                                        <p class="mt-md-0 mt-3 offset-2">Lista dei topic disponibili (massimo 5):</p>
                                    </div>
                                    <div id="TopicList" class="col-9 offset-2" style="max-height: 170px; overflow-y: auto; display: flex; flex-wrap: wrap;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 d-flex mt-3 flex-column justify-content-center align-items-center">
                                <div class="form-group">
                                    <label for="description" class="form-label">Descrizione (massimo 100 caratteri)</label>
                                    <textarea class="form-control" name="description" id="description" maxlength="100" rows="5" cols="42" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 d-flex mt-3 flex-column justify-content-center align-items-center">
                                <div class="form-group">
                                    <label for="profilePic" class="form-label">Immagine profilo:</label>
                                    <input type="file" class="form-control" name="profilePic" id="profilePic" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 d-flex mt-3 flex-column justify-content-center align-items-center">
                                <div class="form-group">
                                    <label for="backgroundPic" class="form-label">Immagine di Background:</label>
                                    <input type="file" class="form-control" name="backgroundPic" id="backgroundPic" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="row container-fluid text-left">
                            <div class="col-12 mb-2 d-flex flex-column justify-content-center align-items-center text-center">
                                <div class="form-group" style="color:#8B0000;" >
                                    <div id="errorTopic" class="mt-1 mb-1 error-message" style="display: none;color:#8B0000 !important;">
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
        <script src="../../JAVASCRIPT/Profile/ValidateUpdateProfileForm.js"  type="module"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>