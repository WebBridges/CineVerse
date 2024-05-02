document.addEventListener('DOMContentLoaded', async (eventMain) => {
    //creiamo ed inviamo il codice
    let data = await createCodeFor2FA();
    setTimeout(function() {
        const resendButton = document.getElementById("resend");
        if (resendButton) {
            resendButton.addEventListener("click", async function() {
                await createCodeFor2FA();
            });
        }
    }, 0);
    if(data === "true"){
        //nel bottone verifichiamo se il codice è corretto
        document.getElementById("submitBtn").addEventListener("click",async function(event) {
            event.preventDefault();
                        let code = document.getElementById("2fa").value;
                        let result = await checkCodeFor2FA(code);
                        if( result == "true") {
                            event.target.form.submit();
                        } else {
                            document.getElementById("error-message").classList.remove("d-none");
                            return false;
                        }
        });
    }
});

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

async function createCodeFor2FA(){
    let response = await fetch('../../PHP/Access/2FA.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    });
    let data = await response.text();
    return data;
}