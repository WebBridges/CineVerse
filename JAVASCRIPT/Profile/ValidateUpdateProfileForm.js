import { GetUsernameInfo } from "../Utils/utils.js";

document.addEventListener('DOMContentLoaded', async (event) => {
    await LoadUserSettingsAccount();
    document.getElementById('FormProfile').addEventListener('submit', async function(e) {
        e.preventDefault();
        let checkedCount = document.querySelectorAll('input[type="checkbox"].form-check-input:checked').length;
        let errors = document.getElementsByClassName('error-message');
        for(let i = 0; i < errors.length; i++) {
            errors[i].style.display = 'none';
        }
        if (checkedCount < 2) {
            let errorTopic = document.getElementById('errorTopic');
            errorTopic.style.display = 'block';
            return;
        } else {
            e.target.submit();
        }
    });
});



async function LoadUserSettingsAccount(){

    let userInfo = await GetUsernameInfo();
    let userTopics = userInfo.topics;
    if(userInfo.Descrizione != null){
        document.getElementById('description').value = userInfo.Descrizione;
    }

    for(let i = 0; i < userTopics.length; i++) {
        let topicId = userTopics[i];
        document.getElementById(topicId).checked = true;
    }
}


