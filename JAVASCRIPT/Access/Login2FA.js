
//creiamo ed inviamo il codice
let data = createCodeFor2FA();
if(data === "true"){
    //nel bottone verifichiamo se il codice è corretto
    document.getElementById("2faButton").addEventListener("click",async function(event) {
        event.preventDefault();
                    let code = document.getElementById("2faCode").value;
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

async function createCodeFor2FA(){
    let response = await fetch('../../template/2FA.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    });
    let data = await response.text();
    console.log(data);
    return data;
}