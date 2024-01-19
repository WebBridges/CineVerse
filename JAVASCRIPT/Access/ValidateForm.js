function checkForm(){
    let name = document.getElementById("name").value;
    let surname = document.getElementById("surname").value;
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let recoveryEmail = document.getElementById("recoveryEmail").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let birthDate = document.getElementById("birthDate").value;
    let bio = document.getElementById("bio").value;
    let profilePic = document.getElementById("profilePic").value;
    let ageControl = new Date();
    ageControl.setFullYear(currentDate.getFullYear() - 13);

    let regex= /[^a-zA-Z ]/g;
    let regexExtended = /[^a-zA-Z0-9 _]/g;
    let regexPassword = /[^a-zA-Z0-9 _!@#$%^*]/g;


    if(regex.test(name) == true){
        swal({
            title: "Attenzione!",
            text: "Il nome può contenere solo lettere e spazi",
            icon: "warning",
            button: "OK",
        });
        return false;
    }

    if(regex.test(surname) == true){
        swal({
            title: "Attenzione!",
            text: "Il cognome può contenere solo lettere e spazi",
            icon: "warning",
            button: "OK",
        });
        return false;
    }

    if(regexExtended.test(username) == true){
        swal({
            title: "Attenzione!",
            text: "Lo username può contenere solo lettere, numeri, spazi e l'underscore",
            icon: "warning",
            button: "OK",
        });        
        return false;
    } else {

        /*Verifichiamo che lo username non sia già presente nel database */
        fetch('CheckUsername.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${username}`,
        })
        .then(response => response.text())
        .then(data => {
            if (data === "Username already taken") {
                swal({
                    title: "Attenzione!",
                    text: "Username già presente",
                    icon: "warning",
                    button: "OK",
                });
                return false;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    /*Verifichiamo che la email non sia già presente nel database */
  
    fetch('CheckEmail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${email}`,
        })
        .then(response => response.text())
        .then(data => {
            if (data === "Email already taken") {
                swal({
                    title: "Attenzione!",
                    text: "Email già presente",
                    icon: "warning",
                    button: "OK",
                });
                return false;
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });    

    if(recoveryEmail && email == recoveryEmail){
        swal({
            title: "Attenzione!",
            text: "La mail di recupero non può essere uguale alla mail principale",
            icon: "warning",
            button: "OK",
        });            
        return false;
        }

    if(regexPassword.test(password)==true){
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

    if(birthDate > ageControl){
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
            text: "Puoi selezionare al massimo 5 argomenti",
            icon: "warning",
            button: "OK",
        });
        return false;
    }
    return true;
}