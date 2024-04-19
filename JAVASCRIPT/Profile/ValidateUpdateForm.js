document.getElementById('FormRegistration').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    let currentUsername= await GetUsername();
    let currentEmail=await GetEmail();

    // Controllo dei campi
    let name = document.getElementById('name').value;
    let surname = document.getElementById('surname').value;
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let checkedCount = document.querySelectorAll('input[type="checkbox"].form-check-input:checked').length;
    let inputDate = new Date(document.getElementById('birthDate').value);
    let currentDate = new Date();
    currentDate.setFullYear(currentDate.getFullYear() - 14);

    console.log(checkedCount);
    console.log(document.querySelectorAll('input[type="checkbox"].form-check-input:checked'));

    let regex= /[^a-zA-Z ]/g;
    let regexExtended = /[^a-zA-Z0-9 _]/g;
    let regexPassword = /[^a-zA-Z0-9 _!@#$%^*]/g;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Reset dei messaggi di errore
    let errors = document.getElementsByClassName('error-message');
    for(let i = 0; i < errors.length; i++) {
        errors[i].style.display = 'none';
    }

    let isValid = true;

    if (isValid && (!name || name.length > 30 ||regex.test(name))) {
        document.getElementById('errorName').style.display = 'block';
        isValid = false;
    }

    if(isValid && (!surname || surname.length > 30 || regex.test(surname))) {
        document.getElementById('errorSurname').style.display = 'block';
        isValid = false;
    }

    if(currentUsername!==username){
        if (isValid) {
            if(!username || regexExtended.test(username)) {
                document.getElementById('usernameSpecialChar').style.display = 'block';
                isValid = false;
            } else if (!(await checkUsername(username))) {
                document.getElementById('usernameNotAvaible').style.display = 'block';
                isValid = false;
            }
        }
    }

    if(currentEmail!==email){
        if (isValid && (!email || !(await checkEmail(email)) || !(emailRegex.test(email)))) {
            document.getElementById('errorEmail').style.display = 'block';
            isValid = false;
        }
    }

    if(isValid && password.length!=0) {
        if (password.length < 8) {
            document.getElementById('passwordLength').style.display = 'block';
            isValid = false;
        } else if (regexPassword.test(password)) {
            document.getElementById('passwordSpecialChar').style.display = 'block';
            isValid = false;
        }
    }

    if(isValid && (isNaN(inputDate) || inputDate > currentDate)) {
        document.getElementById('errorAge').style.display = 'block';
        isValid = false;
    }

    if(isValid && checkedCount<2) {
        document.getElementById('errorTopic').style.display = 'block';
        isValid = false;
    }
    // Se tutti i campi sono validi, invia il form
    if (isValid) {
        e.target.submit();
    } else{
        return false;
    }
});


async function checkUsername(username) {
    const response = await fetch('../../PHP/Access/CheckUsername.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${username}`,
    });

    const data = await response.text();

    if (data === "Username_exist") {
        return false;
    }

    return true;
}

async function checkEmail(email) {
    const response = await fetch('../../PHP/Access/CheckEmail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${email}`,
    });

    const data = await response.text();

    if (data === "Email_exist") {
        return false;
    }

    return true;
}

async function GetUsername(){
    
    const response = await fetch('../../PHP/Profile/getUsername.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    return data.username;  
}

async function GetEmail(){
    
    const response = await fetch('../../PHP/Profile/getEmail.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    return data.email;  
}