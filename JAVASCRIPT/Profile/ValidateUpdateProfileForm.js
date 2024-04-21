import { GetUsernameInfo } from "../Utils/utils.js";

document.addEventListener('DOMContentLoaded', async (event) => {
    await LoadUserSettingsAccount();
    document.getElementById('FormRegistration').addEventListener('submit', async function(e) {
        e.preventDefault();
        let fileInput = document.getElementById('profilePic');
        let file = fileInput.files[0];
        console.log(file.name);
        let checkedCount = document.querySelectorAll('input[type="checkbox"].form-check-input:checked').length;
        console.log(checkedCount);
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


