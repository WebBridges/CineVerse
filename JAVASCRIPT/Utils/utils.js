export { GetUsernameInfo, GetUsername };

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
