
document.getElementById("FormRegistration").addEventListener('submit',async function(event) {

    event.preventDefault();


    let name = document.getElementById("name").value;
    let surname = document.getElementById("surname").value;
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let recoveryEmail = document.getElementById("recoveryEmail").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let birthDate = document.getElementById("birthDate").value;
    let bio = document.getElementById("bio").value;
    let DateControl = new Date(birthDate);
    let ageControl = new Date();
    ageControl.setFullYear(ageControl.getFullYear() - 13);

    let regex= /[^a-zA-Z ]/g;
    let regexExtended = /[^a-zA-Z0-9 _]/g;
    let regexPassword = /[^a-zA-Z0-9 _!@#$%^*]/g;

    

    if(name.match(regex)){
        swal({
            title: "Attenzione!",
            text: "Il nome può contenere solo lettere e spazi",
            icon: "warning",
            button: "OK",
        });
        return false;
    }

    if(surname.match(regex)){
        swal({
            title: "Attenzione!",
            text: "Il cognome può contenere solo lettere e spazi",
            icon: "warning",
            button: "OK",
        });
        return false;
    }

    if(username.match(regexExtended)){
        swal({
            title: "Attenzione!",
            text: "Lo username può contenere solo lettere, numeri, spazi e l'underscore",
            icon: "warning",
            button: "OK",
        });        
        return false;
    } 

    /*verificare se lo username è già presente nel database*/
    if(await checkUsername(username)=== false){
        return false;
    }

    /*verificare se la mail è già presente nel database*/
    if(await checkEmail(email)=== false){
        return false;
    }

    if(recoveryEmail && email == recoveryEmail){
        swal({
            title: "Attenzione!",
            text: "La mail di recupero non può essere uguale alla mail principale",
            icon: "warning",
            button: "OK",
        });            
        return false;
        }

    if(password.length < 8){
        swal({
            title: "Attenzione!",
            text: "La password deve contenere almeno 8 caratteri",
            icon: "warning",
            button: "OK",
        });
        return false;
    }

    if(password.match(regexPassword)){
        swal({
            title: "Attenzione!",
            text: "La password può contenere solo lettere, numeri \n e i seguenti caratteri speciali: _!@#$%^*",
            icon: "warning",
            button: "OK",
        });        
        return false;
    }
    if(password != confirmPassword){
        swal({
            title: "Attenzione!",
            text: "Le password non coincidono",
            icon: "warning",
            button: "OK",
        });        
        return false;
    }

    if(DateControl > ageControl){
        swal({
            title: "Attenzione!",
            text: "Devi avere almeno 13 anni per registrarti",
            icon: "warning",
            button: "OK",
        });        
        return false;
    }
   
    if(!document.querySelectorAll("input[type='checkbox']:checked").length){
        swal({
            title: "Attenzione!",
            text: "Devi selezionare almeno un topic di interesse",
            icon: "warning",
            button: "OK",
        });
        return false;
    }
    // Se il form è valido, invialo
    event.target.submit();

});

async function checkUsername(username) {
    const response = await fetch('../../template/CheckUsername.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${username}`,
    });

    const data = await response.text();

    if (data === "Username_exist") {
        swal({
            title: "Attenzione!",
            text: "Username già presente",
            icon: "warning",
            button: "OK",
        });
        return false;
    }

    return true;
}

async function checkEmail(email) {
    const response = await fetch('../../template/CheckEmail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${email}`,
    });

    const data = await response.text();

    if (data === "Email_exist") {
        swal({
            title: "Attenzione!",
            text: "Email già presente",
            icon: "warning",
            button: "OK",
        });
        return false;
    }

    return true;
}