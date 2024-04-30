export { 
    GetUsernameInfo, GetUsername, GetFollowerCount, GetFollowingCount, loadLikes, loadUserImage, getVotesNumber,
    getVotesForOptionNumber, checkVoted, calcVotesPercentage, vote, createSurveyElement, getMedia
};

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

async function loadLikes(IDpost) {
    const response = await fetch("../../PHP/user/load_post_likes.php?IDpost=" + IDpost);
    const nLikes = await response.json();
    return nLikes;
}

async function loadUserImage(username) {
    const response = await fetch("../../PHP/user/load_user_image.php?user=" + username);
    const image = await response.json();
    return image;
}

async function getVotesNumber(IDpost) {
    const response = await fetch("../../PHP/user/load_votes_number.php?IDpost=" + IDpost);
    const votes = await response.json();
    return votes;
}

async function getVotesForOptionNumber(IDpost, option) {
    const response = await fetch("../../PHP/user/load_votes_for_option_number.php?IDpost=" + IDpost + "&option=" + option);
    const votes = await response.json();
    return votes;
}

async function checkVoted(IDpost, option) {
    const request = "../../PHP/user/check_voted.php?IDpost=" + IDpost + "&option=" + option + "&username=" + GetUsername();
    const response = await fetch(request);
    const voted = await response.json();
    return voted;
}

function calcVotesPercentage(votesForOption, nVotes) {
    if (nVotes == 0) {
        return 0;
    } else {
        return Math.trunc(votesForOption/nVotes*100);
    }
}

async function vote(post, option) {
    const voted = await checkVoted(post.IDpost, option.testo);
    const request = voted ? "../../PHP/user/remove_vote_option.php" : "../../PHP/user/add_vote_option.php";
    const responde = await fetch(request, {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "IDpost": post.IDpost,
            "option": option
        })
    });
}

async function createSurveyElement(post, media) {
    let nVotes = await getVotesNumber(post.IDpost);
    let survey = document.createElement("div");
    survey.className = "survey-container border border-2 border-black rounded p-3";
    survey.id = "survey" + post.IDpost;
    let options = media;
    for (let i = 0; i < options.length; i++) {
        let voted = await checkVoted(post.IDpost, options[i].testo);

        let optionContainer = document.createElement("div");
        optionContainer.className = "row mb-3";
        
        let optionValue = document.createElement("div");
        optionValue.addEventListener("click", function (post, option) { 
            return function() {
                vote(post, option).then(() => {
                    reloadSurvey(post);
                });
            }; 
        }(post, options[i]));
        optionValue.className = "col-10";
        let option = document.createElement("button");
        option.className = "survey-option white-text m-0 pt-2 pb-2";
        if (voted) {
            option.classList.add("border", "border-3", "border-white");
        }
        option.id = "option" + post.IDpost + options[i].testo;
        option.innerHTML = options[i].testo;
        
        let optionVotes = document.createElement("div");
        optionVotes.className = "col-2";
        let votes = document.createElement("p");
        let votesForOption = await getVotesForOptionNumber(post.IDpost, options[i].testo);
        votes.className = "survey-votes white-text m-0 pt-2 pb-2";
        votes.innerHTML = calcVotesPercentage(votesForOption, nVotes) + "%";
        
        optionValue.appendChild(option);
        optionVotes.appendChild(votes);
        optionContainer.appendChild(optionValue);
        optionContainer.appendChild(optionVotes);
        survey.appendChild(optionContainer);
    };
    
    let footer = document.createElement("div");
    footer.className = "row";

    let footerHint = document.createElement("div");
    footerHint.className = "col-8";
    let hint = document.createElement("p");
    hint.className = "white-text text-start m-0";
    hint.innerHTML = options[0].opzione == "radio" ? "Click on an option to vote" : "Click one or more options to vote";
    footerHint.appendChild(hint);

    let footerTotalVotes = document.createElement("div");
    footerTotalVotes.className = "col-4";
    let totalVotes = document.createElement("p");
    totalVotes.className = "white-text text-end m-0";
    totalVotes.innerHTML = "Total votes: " + nVotes;
    footerTotalVotes.appendChild(totalVotes);

    footer.appendChild(footerHint);
    footer.appendChild(footerTotalVotes);
    survey.appendChild(footer);
    return survey;
}

async function reloadSurvey(post) {
    const media = await getMedia(post.IDpost);
    const survey = await createSurveyElement(post, media.data);
    const oldSurvey = document.getElementById("survey" + post.IDpost);
    oldSurvey.replaceWith(survey);
}

async function getMedia(IDpost) {
    const response = await fetch("../../PHP/Home/LoadPostMedia.php?IDpost=" + IDpost);
    const value = await response.json();
    return value;
}