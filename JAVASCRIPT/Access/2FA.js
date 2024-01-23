document.getElementById("Process").addEventListener("click",async function() {
    document.getElementById("underSection").innerHTML = `
        <p>Inserire il codice ricevuto tramite Email</p>
        <form action='template/Process2FA.php' method='post'>
            <input type='text' name='2fa' id='2fa' placeholder='codice' maxlength="10" required>
            <input type='submit' value='conferma' id='conferma' class='buttonOrange'>
        </form>
    `;

    if( await createCodeFor2FA() || true) {
        setTimeout(function() {
            document.getElementById("conferma").addEventListener("click",async function(event) {
                event.preventDefault();
                let code = document.getElementById("2fa").value;
                let result = await checkCodeFor2FA(code);
                if( result == "true") {
                   fetch('../../template/SetActive2FA.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                    });
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
    const response = await fetch('../../template/2FA.php', {
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
    const response = await fetch('../../template/Check2FA.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `code=${code}`,
    });
    const data = await response.text();
    return data;
}
