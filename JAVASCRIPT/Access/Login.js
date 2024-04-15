const form = document.querySelector("form");

form.addEventListener("submit", async function(event) {
    event.preventDefault();
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    form.classList.add("was-validated");
    
    if (await checkPassword(password,email) === false || await checkEmail(email) === false) {
        
        const errorMessage = document.getElementById("error-message");
        errorMessage.textContent = "Email or password is incorrect";
        errorMessage.classList.remove('d-none');
        return false;
    } else {
        event.target.submit();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var elements = document.getElementsByTagName("INPUT");
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninput = function() {
            if (this.validity.valid) {
                this.classList.remove('is-valid');
            }
            this.classList.remove('is-invalid');
        }

        elements[i].onblur = function() {
            if (!this.validity.valid) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        }
    }
});


/*Funzioni per controllo */
async function checkEmail(email) {
    const response = await fetch('../../PHP/Access/CheckEmail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${email}`,
    });

    const data = await response.text();
    return data === "Email_exist";
}

async function checkPassword(password,email) {
    const response = await fetch('../../PHP/Access/CheckPassword.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `password=${password}&email=${email}`,
    });

    const data = await response.text();
    return data === "Password_correct";
}