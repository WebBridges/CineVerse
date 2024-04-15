document.addEventListener('DOMContentLoaded', async (event) => {
    await LoadUserSettingsAccount();
});


async function LoadUserSettingsAccount(){

    let userInfo = await GetUsernameInfo();
    let sesso = userInfo.Sesso;
    let userTopics = userInfo.topics;

    document.getElementById('name').value = userInfo.Nome;
    document.getElementById('surname').value = userInfo.Cognome;
    document.getElementById('username').value = userInfo.Username;
    document.getElementById('email').value = userInfo.Email;
    document.getElementById('birthDate').value = userInfo.Data_nascita;
    if(sesso!=null){
        document.querySelector(`input[name="gender"][value="${sesso}"]`).checked = true;
    }
    if(userInfo.tFA==1){
        document.getElementById('checkboxTFA').checked = true;
    }
    
    for(let i = 0; i < userTopics.length; i++) {
        let topicId = userTopics[i];
        document.getElementById(topicId).checked = true;
        }
        
}



async function GetUsernameInfo(){
    let username = await GetUsername();
    const response = await fetch('../../PHP/Profile/getUserInfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${username}`,
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const contentType = response.headers.get("content-type");
    if (contentType && contentType.indexOf("application/json") !== -1) {
        const data = await response.json();
        return data; 
    } else {
        throw new Error(`Expected JSON but received a ${contentType} and ${await response.text()}`);
    } 
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