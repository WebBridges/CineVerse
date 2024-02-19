document.getElementById("Process").addEventListener("click",async function() {
    document.getElementById("underSection").innerHTML = `
        <p>Inserire il codice ricevuto tramite Email</p>
        <form action='../../PHP/Access/Process2FA.php' method='post'>
            <input type='text' name='2fa' id='2fa' placeholder='codice' maxlength="10" required>
            <input type='submit' value='conferma' id='conferma' class='buttonOrange'>
        </form>
        <button id='resend' class='buttonOrange'>Rinvia codice</button>
    `;
    setTimeout(function() {
        const resendButton = document.getElementById("resend");
        if (resendButton) {
            resendButton.addEventListener("click", async function() {
                await createCodeFor2FA();
            });
        }
    }, 0);

    if( await createCodeFor2FA()) {
        setTimeout(function() {
            document.getElementById("conferma").addEventListener("click",async function(event) {
                event.preventDefault();
                let code = document.getElementById("2fa").value;
                let result = await checkCodeFor2FA(code);
                if( result == "true") {
                    event.target.form.submit();
                } else {
                    swal({
                        title: "Attenzione!",
                        text: "Codice errato",
                        icon: "warning",
                        button: "OK",
                    });
                    return false;
                }
                
            });
        }, 0);
    }
});


async function createCodeFor2FA() {
    const response = await fetch('../../PHP/Access/2FA.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    });
    const data = await response.text();
    console.log(data);
    return data === "true";
}

async function checkCodeFor2FA(code){
    const response = await fetch('../../PHP/Access/Check2FA.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `code=${code}`,
    });
    const data = await response.text();
    return data;
}
