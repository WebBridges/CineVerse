const phpPath = "../../PHP";

// Get the logged username and action to do from the URL
const urlParams = new URLSearchParams(window.location.search);
const URLusername = urlParams.get('username');
const URLaction = urlParams.get('action');

document.getElementsByTagName("title")[0].innerHTML = "Cineverse" + " - " + URLaction;
document.getElementById("action").innerHTML = URLaction;
document.getElementById("username").innerHTML = URLusername;

async function retrieveUsers() {
    const usersList = document.getElementById('usersList');
    let response;
    if (URLaction == "followers") {
        response = await fetch(phpPath + "/user/load_followers.php?username=" + URLusername);
    } else if (URLaction == "following") {
        response = await fetch(phpPath + "/user/load_following.php?username=" + URLusername);
    }
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    const users = await response.json();
    
    var usernameNotFound = `<div class=" col-12  d-flex align-items-center px-3"><div>
                                <p class="pt-3 px-4 text-center usernameLabel">Nessun username</p></div>
                                </div>`;
    if (users.length == 0){
        usersList.innerHTML = usernameNotFound;
        return;
    } else {
        let allUsersHTML="";
        for (let user of users) {
            let username = user.Username;
            let profilePic = user.Foto_profilo;
            if(profilePic === null){
                profilePic = "../../img/default-user.jpg";
            } else{
                profilePic = "../../img/" + profilePic;
            }
            let userHTML = `<div class=" col-12  d-flex align-items-center px-3 mt-3 mb-2">
                                <div class="col-2 user_images">
                                    <img src=${profilePic} alt="user image" class="img-fluid overflow-hidden">
                                </div>
                                <div>
                                <a href="SearchUserPage.php?username=${username}" class="pt-3 px-4 usernameLabel">${username}</a>
                                </div>
                            </div>`;
            allUsersHTML += userHTML;
        }
        usersList.innerHTML = allUsersHTML;
    }
}

retrieveUsers();