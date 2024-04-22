export { GetUsernameInfo, GetUsername, GetFollowerCount, GetFollowingCount};

async function GetUsernameInfo(usernameURL=null){
    let username;
    if(usernameURL===null){
        username = await GetUsername();
    } else {
        username = usernameURL;
    }
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

async function GetFollowerCount(usernameURL=null){
    let username;
    if(usernameURL==null){
        username = await GetUsername();
    } else {
        username = usernameURL;
    }
    const response = await fetch('../../PHP/user/getFollowerCount.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${username}`
    });
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data= await response.json();
    return data;
}

async function GetFollowingCount(usernameURL=null){
    let username;
    if(usernameURL==null){
        username = await GetUsername();
    } else {
        username = usernameURL;
    }
    const response = await fetch('../../PHP/user/getFollowingCount.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${username}`
    });
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data= await response.json();
    return data;
}