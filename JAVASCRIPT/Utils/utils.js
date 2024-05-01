export { 
    GetUsernameInfo, GetUsername, GetFollowerCount, GetFollowingCount, loadLikes, loadUserImage, getVotesNumber,
    getVotesForOptionNumber, checkVoted, calcVotesPercentage, vote, createSurveyElement, getMedia, like, checkLike,
    sendNotificationEmail, showComments, loadComments, loadCommentLikes, checkCommentLike, likeComment, submitComment, 
    deleteComment, isOwner,
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

async function like(IDpost) {
    const liked = await checkLike(IDpost, GetUsername());
    const request = liked ? "../../PHP/user/remove_like_post.php" : "../../PHP/user/add_like_post.php";
    await fetch(request, {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "IDpost": IDpost
        })
    });
    const likeButton = document.getElementById("likes-button" + IDpost);
    const nLikes = document.getElementById("post-count-likes" + IDpost);
    if (liked) {
        nLikes.innerHTML = parseInt(nLikes.innerHTML) - 1;
        likeButton.innerHTML = "<em class='fa-regular fa-heart' style='color: #ffffff;'></em>";
    } else {
        nLikes.innerHTML = parseInt(nLikes.innerHTML) + 1;
        likeButton.innerHTML = "<em class='fa-solid fa-heart' style='color: #ff8500;'></em>";
        sendNotificationEmail(IDpost, "post");
    }
}

async function checkLike(IDpost, username) {
    const request = "../../PHP/user/check_post_like.php?IDpost=" + IDpost + "&username=" + username;
    const response = await fetch(request);
    const liked = await response.json();
    return liked;
}

async function sendNotificationEmail(id, type) {
    const response = await fetch("../../PHP/user/send_notification_email.php?id=" + id + "&type=" + type);
}

async function isOwner(username) {
    if (username == await GetUsername()) {
        return true;
    }
    return false;
} 

async function showComments(IDpost) {
    //const comModal = document.getElementById("comments-modal");
    const commentsModal = document.getElementById("comments-modal");
    const commentsModalBody = commentsModal.querySelector(".modal-body");
    while (commentsModalBody.getElementsByClassName('comment-container').length > 0) {
        commentsModalBody.removeChild(commentsModalBody.lastChild);
    }
    const comments = await loadComments(IDpost);
    const template = document.getElementById("template-comments");
    if (comments.length == 0) {
        let clone = template.content.cloneNode(true);
        clone.querySelector("img").style.visibility = "hidden";
        clone.querySelector("a").style.visibility = "hidden";
        clone.querySelector(".comment").textContent = "No comments yet";
        clone.querySelector(".like-comment-button").style.visibility = "hidden";
        clone.querySelector(".nLikes").style.visibility = "hidden";
        commentsModalBody.appendChild(clone);
    }
    for (let i = 0; i < comments.length; i++) {
        let comment = comments[i];
        let clone = template.content.cloneNode(true);
        let liked = await checkCommentLike(comment.IDcommento, GetUsername());
        let userImage = await loadUserImage(comment.username_utente);
        let nLikes = await loadCommentLikes(comment.IDcommento);
        
        clone.querySelector(".comment-container").setAttribute("name", "comment" + comment.IDcommento);
        if (userImage != null) {
            clone.querySelector("img").src = "../../img/" + userImage;
        }
        clone.querySelector("a").textContent = comment.username_utente;
        clone.querySelector("a").href = "/CineVerse/HTML/Profile/SearchUserPage.php?username=" + comment.username_utente;
        clone.querySelector(".comment").textContent = comment.corpo;
        /*if (comment.owner) {
            clone.querySelector(".trash-button").classList.remove("invisible");
            clone.querySelector(".trash-button").addEventListener("click", function() { removeComment(comment.comment_id, post_id); })
        }*/
        clone.querySelector(".nLikes").innerHTML = nLikes
        const likeButton = clone.querySelector(".like-comment-button");
        likeButton.addEventListener("click", function () { likeComment(comment.IDcommento)});
        if (liked) {
            likeButton.innerHTML = "<em class='fa-solid fa-heart' style='color: #ff8500;'></em>";
        }
        const trash = clone.querySelector(".delete-comment-button");
        trash.addEventListener("click", function() { deleteComment(comment); });
        if (await isOwner(comment.username_utente)) {
            trash.classList.remove("invisible");
        }
        commentsModalBody.appendChild(clone);
    }
    const modalFooter = commentsModal.querySelector(".modal-footer");
    /*modalFooter.querySelector("form").onkeydown = function(event) {
        return event.key != 'Enter';
    }*/
    const submitCommentButton = modalFooter.querySelector("button");
    const newSubmitCommentButton = submitCommentButton.cloneNode(true);
    submitCommentButton.parentNode.replaceChild(newSubmitCommentButton, submitCommentButton);
    newSubmitCommentButton.addEventListener("click", function() { submitComment(IDpost); });
}

async function loadComments(IDpost) {
    const response = await fetch("../../PHP/user/load_comments.php?IDpost=" + IDpost);
    const comments = await response.json();
    return comments;
}

async function loadCommentLikes(IDcomment) {
    const response = await fetch("../../PHP/user/load_comment_likes.php?IDcomment=" + IDcomment);
    const nLikes = await response.json();
    return nLikes;
}

async function checkCommentLike(IDcomment, username) {
    const request = "../../PHP/user/check_comment_like.php?IDcomment=" + IDcomment + "&username=" + username;
    const response = await fetch(request);
    const liked = await response.json();
    return liked;
}

async function likeComment(IDcomment) {
    const liked = await checkCommentLike(IDcomment, GetUsername());
    const request = liked ? "../../PHP/user/remove_like_comment.php" : "../../PHP/user/add_like_comment.php";
    await fetch(request, {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "IDcomment": IDcomment
        })
    });
    const commentContainer = document.getElementsByName("comment" + IDcomment)[0];
    const likeButton = commentContainer.querySelector(".like-comment-button");
    const nLikes = commentContainer.querySelector(".nLikes")
    if (liked) {
        nLikes.innerHTML = parseInt(nLikes.innerHTML) - 1;
        likeButton.innerHTML = "<em class='fa-regular fa-heart' style='color: #ffffff;'></em>";
    } else {
        nLikes.innerHTML = parseInt(nLikes.innerHTML) + 1;
        likeButton.innerHTML = "<em class='fa-solid fa-heart' style='color: #ff8500;'></em>";
        sendNotificationEmail(IDcomment, "comment");
    }
}

async function submitComment(IDpost) {
    const commentsModal = document.getElementById("comments-modal");
    const commentText = commentsModal.querySelector("input").value;
    commentsModal.querySelector("input").value = ""; 
    if (!commentText.replace(/\s/g, '').length) {
        return;
    }
    await fetch("../../PHP/user/add_comment.php", {
        method: "POST",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "IDpost": IDpost,
            "commentText": commentText
        })
    });
    showComments(IDpost);
}

async function deleteComment(comment) {
    const response = await fetch("../../PHP/user/delete_comment.php?IDcomment=" + comment.IDcommento);
    const result = await response.json();
    if (result) {
        showComments(comment.IDpost);
    }
}