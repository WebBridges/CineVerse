document.getElementById("loginForm").addEventListener("submit", async function(event) {
    
    event.preventDefault();
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (await checkEmail(email) === false) {
        return false;
    } else{
        if (await checkPassword(password,email) === false) {
            return false;
        } else {
            event.target.submit();
        }
    }

});

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
        return true;
    } else {
        swal({
            title: "Attenzione!",
            text: "Email non valida",
            icon: "warning",
            button: "OK",
        });
        return false;
    }
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

    if (data === "Password_wrong") {
        swal({
            title: "Attenzione!",
            text: "Password errata",
            icon: "warning",
            button: "OK",
        });
        return false;
    } else {
        return true;
    }
}