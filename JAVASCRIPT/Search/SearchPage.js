document.addEventListener("DOMContentLoaded", function() {
    var searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', async function() {
        // Il valore dell'input è cambiato, aggiorna l'HTML come necessario
        var inputValue = this.value;
        var searchList = document.getElementById('searchList');
        var usernameNotFound = `<div class=" col-12  d-flex align-items-center px-3"><div>
                                <p class="pt-3 px-4 text-center" id="usernameLabel">Username non trovato</p></div>
                                </div>`;

        // Aggiorna l'HTML in base al valore dell'input
        if (!inputValue || inputValue.length === 0) {
            searchList.innerHTML = usernameNotFound;
            return;
        } else {
            users =await searchUsers(inputValue);
            if (users === null){
                searchList.innerHTML = usernameNotFound;
                return;
            } else {
                let allUsersHTML="";
                for (let user of users) {
                    let username = user.Username;
                    let profilePic = user.Foto_profilo;
                    let userHTML = `<div class=" col-12  d-flex align-items-center px-3">
                                        <div class="col-2 user_images">
                                            <img src="../../img/default-user.webp" alt="user image" class="img-fluid overflow-hidden" id="user_images">
                                        </div>
                                        <div>
                                            <p class="pt-3 px-4" id="usernameLabel">${username}</p>
                                        </div>
                                    </div>`;
                    allUsersHTML += userHTML;
                }
                searchList.innerHTML = allUsersHTML;
            }   
        }

    });
});

async function searchUsers(inputValue) {

    const response = await fetch('../../PHP/Search/GetSearchUsers.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `inputValue=${inputValue}`,
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    if(data.error === 'No users found'){
        return null;
    } else {
        return data;
    }
}