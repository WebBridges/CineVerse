import { GetFollowerCount } from "../Utils/utils.js";

document.addEventListener('DOMContentLoaded', async (event) => {
    await loadFollowButton();
});

async function loadFollowButton(){
    let params = new URLSearchParams(window.location.search);
    let usernameURL = params.get('username');

    if(await checkFollow(usernameURL)){
        addFollowedButton();
    } else {
        addFollowButton();
    }
}

async function addFollowButton(){
    let params = new URLSearchParams(window.location.search);
    let usernameURL = params.get('username');
    document.getElementById('buttonField').innerHTML =`<button class="btn btn-primary" id="followButtonNotFollow" style="width: 86%;">segui</button>` ;
    document.getElementById('followButtonNotFollow').addEventListener('click', async (event) => {
        if(await addFollowToUsername(usernameURL)){
            document.getElementById("nFollower").innerHTML = await GetFollowerCount(usernameURL);
            addFollowedButton();
        }
    });
}

async function addFollowedButton(){
    let params = new URLSearchParams(window.location.search);
    let usernameURL = params.get('username');
    document.getElementById('buttonField').innerHTML =`<button class="btn btn-secondary" id="followButtonFollowed" style="width: 86%;">segui già</button>` ;
    document.getElementById('followButtonFollowed').addEventListener('click', async (event) => {
        if(await removeFollowToUsername(usernameURL)){
            document.getElementById("nFollower").innerHTML = await GetFollowerCount(usernameURL);
            addFollowButton();
        }
    });
}

async function checkFollow(usernameURL) {
    const response = await fetch('../../PHP/user/CheckFollow.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `usernameURL=${usernameURL}`,
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const jsonResponse = await response.json();
    return jsonResponse;
}

async function addFollowToUsername(usernameURL) {
    const response = await fetch('../../PHP/user/AddFollow.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `usernameURL=${usernameURL}`,
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const jsonResponse = await response.json(); // Parse the response as JSON
    return jsonResponse;
}

async function removeFollowToUsername(usernameURL) {
    const response = await fetch('../../PHP/user/RemoveFollow.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `usernameURL=${usernameURL}`,
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const jsonResponse = await response.json();
    return jsonResponse;
}