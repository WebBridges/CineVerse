document.addEventListener("DOMContentLoaded",function() {
    document.getElementById("Process").addEventListener("click",async function() {
        document.getElementById("ContentBlock").innerHTML = `
        <div id="MainBlock" class="d-flex flex-column align-items-center" style="width: 330px; height: 290px; margin:auto;">
            <div id="BlockBanner" class="d-flex justify-content-center align-items-center w-100">
                2FA Verification
            </div>
            <div class="mt-4">
                <p>Inserire il codice inviato alla tua mail:</p>
            </div>
            <form id="2FA_Form" class=" mt-1" action="../../PHP/Access/Process2FA.php" method="POST" >
                <div class="mb-1 mt-1">
                    <input type="text" class="form-control" name="2fa" id="2fa" value="" maxlength="15" placeholder="codice" required>
                    <div class="invalid-feedback">
                        Please provide a valid code
                    </div>
                </div>
                <div id="error-message" class="error-message d-none"></div>
                    <div class="d-flex justify-content-center mt-4">
                        <button id="resend" class=" btn btn-secondary me-4">Rinvia codice</button>
                        <button id="conferma" class="btn btn-primary" type="submit">Verifica</button>
                    </div>
            </form>
        </div>
        `;

        document.getElementById("2fa").addEventListener("input", function() {
            if (!this.validity.valid) {
                this.classList.add("is-invalid");
            } else {
                this.classList.remove("is-invalid");
            }
        });

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
                        return false;
                    }
                    
                });
            }, 0);
        }
    });
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
    return data === "true";
}
