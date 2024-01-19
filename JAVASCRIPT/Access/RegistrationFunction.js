
function loadTopicCheckboxes(){
    fetch("../../JSON/TopicTag.json")
        .then(response => {
             if (!response.ok) {
                     throw new Error("HTTP error " + response.status);
                }
            return response.json();
    })
    .then(data => {
        let checkboxHTML = '';
        // Utilizza i dati del file JSON per generare l'HTML dei bottoni
        for(let i = 0; i < data.topic.length; i++) {
            checkboxHTML += `<li><input type="checkbox" id="${data.topic[i].id}" name="${data.topic[i].name}" value="${data.topic[i].id}"><label for="${data.topic[i].id}">${data.topic[i].label}</label></li>`;
        }
        document.getElementById('topic_checkbox').innerHTML = checkboxHTML;
        document.querySelectorAll("input[type='checkbox']").forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                // Controlla il numero di checkbox selezionate
                let checkedCount = document.querySelectorAll("input[type='checkbox']:checked").length;
                if(checkedCount > 5) {
                    // Se ci sono più di 5 checkbox selezionate, deseleziona l'ultima checkbox selezionata
                    this.checked = false;
                    swal({
                        title: "Attenzione!",
                        text: "Puoi selezionare al massimo 5 argomenti",
                        icon: "warning",
                        button: "OK",
                    });
                }
            });
        });
    })
    .catch(function() {
        console.log("An error occurred while fetching the JSON data.");
    });
}

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
}

function unselectRadioButton() {
    var radioButtons = document.getElementsByName('gender');
    for (var i = 0; i < radioButtons.length; i++) {
        // Aggiungi l'event listener solo se non è già stato aggiunto
        if (!radioButtons[i].hasClickListener) {
            radioButtons[i].addEventListener('mousedown', function() {
                if (this.checked && this.wasChecked) {
                    e.preventDefault();
                    this.checked = false;
                }
                this.wasChecked = this.checked;
            });
            // Segna il radiobutton come avente un event listener
            radioButtons[i].hasClickListener = true;
        }
    }
}

// Chiama la funzione unselectRadioButton
unselectRadioButton();