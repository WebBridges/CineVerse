document.addEventListener('DOMContentLoaded', async (event) => {
    await LoadUserSettingsAccount();
});

import { GetUsernameInfo } from "../Utils/utils.js";


async function LoadUserSettingsAccount(){

    let userInfo = await GetUsernameInfo();
    let sesso = userInfo.Sesso;

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
    } else {
        document.getElementById('checkboxTFA').checked = false;    
    }   
}