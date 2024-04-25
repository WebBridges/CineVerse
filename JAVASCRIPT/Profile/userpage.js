const phpPath = "../../PHP";
import { GetUsernameInfo } from "../Utils/utils.js";
import { GetUsername } from "../Utils/utils.js";
import { GetFollowerCount } from "../Utils/utils.js";
import { GetFollowingCount } from "../Utils/utils.js";

const urlParams = new URLSearchParams(window.location.search);
const URLusername = urlParams.get('username');

const openOptionsButtons = document.getElementById("openbtn");
const closeOptions = document.getElementById("closebtn");
let params = new URLSearchParams(window.location.search);
let usernameURL = params.get('username');

if(openOptionsButtons!=null){
    openOptionsButtons.addEventListener("click", function () { openSideBar(); });
}

if(closeOptions!=null){
    closeOptions.addEventListener("click", function () { closeSideBar(); });
}

const photoButton = document.getElementById("photo_button");
const textButton = document.getElementById("text_button");
const surveyButton = document.getElementById("survey_button");

photoButton.addEventListener("click", function () { changePostType(0); });
textButton.addEventListener("click", function () { changePostType(1); });
surveyButton.addEventListener("click", function () { changePostType(2); });

function openSideBar() {
    document.getElementById("mySidebar").style.width = "250px";
}

function closeSideBar() {
    document.getElementById("mySidebar").style.width = "0";
}

async function changePostType(type) {
    if (type === 0) {
        textButton.classList.remove("current_button");
        surveyButton.classList.remove("current_button");
        photoButton.classList.add("current_button");
    } else if (type === 1) {
        surveyButton.classList.remove("current_button");
        photoButton.classList.remove("current_button");
        textButton.classList.add("current_button");
    } else if (type === 2) {
        photoButton.classList.remove("current_button");
        textButton.classList.remove("current_button");
        surveyButton.classList.add("current_button");
    }
    showPost(type);
}

/**
 * Function to load user information
 */
async function loadUserInformation(usernameURL) {
    const usernameInfo = await GetUsernameInfo(usernameURL);
    if(usernameInfo.Foto_background != null){
        document.getElementById("background_image").src ="../../img/" + usernameInfo.Foto_background;
    } else {
        document.getElementById("background_image").src = "../../img/default-background.jpg";
    }

    if(usernameInfo.Foto_profilo != null){
        document.getElementById("user_images").src = "../../img/" + usernameInfo.Foto_profilo;
    } else {
        document.getElementById("user_images").src = "../../img/default-user.jpg";
    }
    const response = await fetch(phpPath + "/user/load_posts_number.php?username=" + usernameInfo.Username);
    const nPosts = await response.json();
    document.getElementById("username").innerHTML = usernameInfo.Username;
    document.getElementById("nPosts").innerHTML = nPosts;
    document.getElementById("nFollower").innerHTML = await GetFollowerCount(usernameInfo.Username);
    document.getElementById("nSeguiti").innerHTML = await GetFollowingCount(usernameInfo.Username);
    document.getElementById("user_description").innerHTML = usernameInfo.Descrizione;
    const topicContainer = document.getElementById("topic-container");
    usernameInfo.topics.forEach(element => {
        let div = document.createElement("div");
        div.classList.add("col-auto");
        let p = document.createElement("p");
        p.innerHTML = element;
        div.appendChild(p);
        topicContainer.appendChild(div);
    });

}

/**
 * All function to load posts
 * 
 */
async function loadPhotos() {
    const request = URLusername != null ? phpPath + "/user/load_posted_photos.php?username=" + URLusername : phpPath + "/user/load_posted_photos.php";
    const response = await fetch(request);
    const posts = await response.json();
    return posts;
}

async function loadText() {
    const request = URLusername != null ? phpPath + "/user/load_posted_text.php?username=" + URLusername : phpPath + "/user/load_posted_text.php";
    const response = await fetch(request);
    const posts = await response.json();
    return posts;
}

async function loadSurvey() {
    const request = URLusername != null ? phpPath + "/user/load_posted_survey.php?username=" + URLusername : phpPath + "/user/load_posted_survey.php";
    const response = await fetch(request);
    const posts = await response.json();
    return posts;
}

async function getType(type) {
    let posts;
    if(type === 0){
        posts = await loadPhotos();
    }else if(type === 1){
        posts = await loadText();
    }else if(type === 2){
        posts = await loadSurvey();
        return posts;
    }
    const returnarray = [];
    posts.forEach(element => {
        returnarray.push(element);
    });
    return returnarray;
}

async function showPost(type) {
    let loadedPosts = await getType(type);
    let loadedPost = [];
    let postsContainerDiv = document.getElementById("post-container");
    while (postsContainerDiv.firstChild) {
        postsContainerDiv.removeChild(postsContainerDiv.firstChild);
    }
    if (loadedPosts.length == 0) {
        console.log("No posts to show");
    } else {
        if(type === 0) {
            //let dim = 0;
            let loadedMedia;
            let path;
            for (let post_index = 0; post_index < loadedPosts.length/2; post_index++) {
                loadedPost = loadedPosts[post_index];
                loadedMedia = loadedPosts[post_index + loadedPosts.length/2];
                path = loadedMedia.foto_video;
                let split = path.split(".");
                if (split[1] == "mp4") {
                    let container = document.createElement('div');
                    let video = document.createElement('video');
                    let img = document.createElement('img');
                    container.classList.add('video-container');

                    // Immagine che indica un video
                    img.alt = 'play-icon-identifier';
                    img.src = "../../img/play_button.jpg";
                    img.className = 'play-icon';
                    
                    //Impostazione degli attributi del video
                    video.src = "../../img/" + path; //percorso del video
                    video.controls = false; //Abilita i controlli del video
                    video.autoplay = false;
                    video.loop = false; 
                    video.muted = false;
                    video.className = 'img-fluid mx-auto d-block border border-black'; // Classe CSS
                    video.id = 'video-id'; // ID del video
                    video.setAttribute("data-bs-toggle", "modal");
                    video.setAttribute("data-bs-target", "#post-modal");
                    video.addEventListener("click", function (post, media) { 
                        return function() {
                            openModalPost(post, media, "video");
                        }; 
                    }(loadedPost, loadedMedia));
                
                    //Inserimento degli elementi nell'html
                    container.appendChild(video);
                    container.appendChild(img);
                    postsContainerDiv.appendChild(container);
                } else {
                    //Creazione dell'elemento immagine
                    let img = document.createElement('img');
                    img.alt = '';
                    img.className = 'img-fluid mx-auto d-block border border-black';
                    img.id = 'photo-id';
                    img.src = "../../img/" + path;
                    img.setAttribute("data-bs-toggle", "modal");
                    img.setAttribute("data-bs-target", "#post-modal");
                    //loadedPost
                    img.addEventListener("click", function (post, media) { 
                        return function() {
                            openModalPost(post, media, "photo");
                        }; 
                    }(loadedPost, loadedMedia));
                    //Inserimento dell'elemento immagine nell'html
                    postsContainerDiv.appendChild(img);
                }
                //dim++;
            }
            /**Prima servira a riempire i buchi nel caso nella linea non si arrivi a 3 post
            let i = 0;
            if (dim % 3 == 1) {
                i = 2;
            } else if (dim % 3 == 2) {
                i = 1;
            }
            for (let j = 0; j < i; j++) {
                let clone = document.importNode(template.content, true);
                clone.querySelector("#video-id").remove();
                clone.querySelector("#photo-id").src = "../../img/default-user.webp";
                clone.querySelector("#photo-id").style.visibility = "hidden";
                postsContainerDiv.appendChild(clone);
            }
            */
        } else if (type === 1) {
            let loadedText;
            for (let text_index = 0; text_index < loadedPosts.length/2; text_index++) {
                loadedPost = loadedPosts[text_index];
                loadedText = loadedPosts[text_index + loadedPosts.length/2];
                let titleContainer = document.createElement('div');
                titleContainer.className = "text-center p-3 text-white border border-black border-top-0 border-bottom-2 border-start-1 border-end-1";
                let title = document.createElement('p');
                title.id = 'text-title';
                title.classList.add("m-0");
                title.innerHTML = loadedPost.titolo;
                titleContainer.setAttribute("data-bs-toggle", "modal");
                titleContainer.setAttribute("data-bs-target", "#post-modal");
                titleContainer.addEventListener("click", function (post, text) { 
                    return function() {
                        openModalPost(post, text, "text");
                    }; 
                }(loadedPost, loadedText));
                titleContainer.appendChild(title);
                postsContainerDiv.appendChild(titleContainer);
            }
        }else if (type === 2) {
            let loadedOptions;
            for (let survey_index = 0; survey_index < loadedPosts["posts"].length; survey_index++) {
                loadedPost = loadedPosts["posts"][survey_index];
                loadedOptions = loadedPosts["options"][loadedPost.IDpost];
                let titleContainer = document.createElement('div');
                titleContainer.className = "text-center p-3 text-white border border-black border-top-0 border-bottom-2 border-start-1 border-end-1";
                let title = document.createElement('p');
                title.id = 'text-title';
                title.classList.add("m-0");
                title.innerHTML = loadedPost.titolo;
                titleContainer.setAttribute("data-bs-toggle", "modal");
                titleContainer.setAttribute("data-bs-target", "#post-modal");
                titleContainer.addEventListener("click", function (post, text) { 
                    return function() {
                        openModalPost(post, text, "text");
                    }; 
                }(loadedPost, loadedOptions));
                titleContainer.appendChild(title);
                postsContainerDiv.appendChild(titleContainer);
            }
        }
    }
}

async function loadUserImage(username) {
    const response = await fetch(phpPath + "/user/load_user_image.php?user=" + username);
    const image = await response.json();
    return image;
}

async function loadLikes(IDpost) {
    const response = await fetch(phpPath + "/user/load_post_likes.php?IDpost=" + IDpost);
    const nLikes = await response.json();
    return nLikes;
}

async function checkLike(IDpost, username) {
    const request = phpPath + "/user/check_post_like.php?IDpost=" + IDpost + "&username=" + username;
    const response = await fetch(request);
    const liked = await response.json();
    return liked;
}

async function like(IDpost) {
    const liked = await checkLike(IDpost, GetUsername());
    const request = liked ? phpPath + "/user/remove_like_post.php" : phpPath + "/user/add_like_post.php";
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
    const likeButton = document.getElementById("likes-button");
    const nLikes = document.getElementById("post-count-likes");
    if (liked) {
        nLikes.innerHTML = parseInt(nLikes.innerHTML) - 1;
        likeButton.innerHTML = "<em class='fa-regular fa-heart' style='color: #ffffff;'></em>";
    } else {
        nLikes.innerHTML = parseInt(nLikes.innerHTML) + 1;
        likeButton.innerHTML = "<em class='fa-solid fa-heart' style='color: #ff8500;'></em>";
        sendNotificationEmail(IDpost, "post");
    }
}

async function sendNotificationEmail(id, type) {
    const response = await fetch(phpPath + "/user/send_notification_email.php?id=" + id + "&type=" + type);
}

async function openModalPost(post, media, type) {
    const postActions = document.getElementById("post-actions");
    const liked = await checkLike(post.IDpost, GetUsername());
    // clean buttons event listeners
    document.getElementById("comments-button").replaceWith(document.getElementById("comments-button").cloneNode(true));
    document.getElementById("likes-button").replaceWith(document.getElementById("likes-button").cloneNode(true));
    // show modal
    document.getElementById("post-title").innerHTML = post.titolo;
    const userImage = await loadUserImage(post.username_utente);
    if (userImage != null) {
        document.getElementById("post-user-photo").src = "../../img/" + userImage;
    }
    
    //the postElement represents the heart of the post, it can be an image, a video, a text or a survey
    let postElement = document.getElementById("post-element");
    while (postElement.firstChild) {
        postElement.removeChild(postElement.firstChild);
    }
    let postDescriptionContainer = document.getElementById("post-description-container");
    while (postDescriptionContainer.firstChild) {
        postDescriptionContainer.removeChild(postDescriptionContainer.firstChild);
    }

    if (type == "photo") {
        let img = document.createElement("img");
        img.id = "post-photo";
        img.classList.add("img-fluid");
        img.src
        img.src = "../../img/" + media.foto_video;
        let description = document.createElement("p")
        description.id = "post-description";
        description.classList.add("white-text");
        description.innerHTML = media.descrizione;

        postElement.appendChild(img);
        addDescriptionToModal(postDescriptionContainer, media.descrizione);
    } else if (type == "video") {
        let video = document.createElement("video");
        video.src = "../../img/" + media.foto_video; //percorso del video
        video.controls = true; //Abilita i controlli del video
        video.autoplay = false;
        video.loop = false; 
        video.muted = false;
        video.className = 'img-fluid mx-auto d-block border border-black'; // Classe CSS
        video.id = 'video-id'; // ID del video

        postElement.appendChild(video);
        addDescriptionToModal(postDescriptionContainer, media.descrizione);
    } else if (type == "text") {
        let paragraph = document.createElement("p");
        paragraph.classList.add("white-text");
        paragraph.innerHTML = media.corpo;

        postElement.appendChild(paragraph);
    }

    document.getElementById("post-username").innerHTML = post.username_utente;
    document.getElementById("post-count-likes").innerHTML = await loadLikes(post.IDpost);
    const likeButton = postActions.querySelector("#likes-button");
    likeButton.addEventListener("click", function () { like(post.IDpost) });
    if (liked) {
        likeButton.innerHTML = "<em class='fa-solid fa-heart' style='color: #ff8500;'></em>";
    } else {
        likeButton.innerHTML = "<em class='fa-regular fa-heart' style='color: #ffffff;'></em>";
    }
    document.getElementById("comments-button").addEventListener("click", function() { showComments(post.IDpost); });
}

async function addDescriptionToModal(parentElement, description) {
    let descriptionElement = document.createElement("p")
    descriptionElement.id = "post-description";
    descriptionElement.classList.add("white-text");
    descriptionElement.innerHTML = description;
    parentElement.appendChild(descriptionElement);    
}

async function loadComments(IDpost) {
    const response = await fetch(phpPath + "/user/load_comments.php?IDpost=" + IDpost);
    const comments = await response.json();
    return comments;
}

async function loadCommentLikes(IDcomment) {
    const response = await fetch(phpPath + "/user/load_comment_likes.php?IDcomment=" + IDcomment);
    const nLikes = await response.json();
    return nLikes;
}

async function checkCommentLike(IDcomment, username) {
    const request = phpPath + "/user/check_comment_like.php?IDcomment=" + IDcomment + "&username=" + username;
    const response = await fetch(request);
    const liked = await response.json();
    return liked;
}

async function likeComment(IDcomment) {
    const liked = await checkCommentLike(IDcomment, GetUsername());
    const request = liked ? phpPath + "/user/remove_like_comment.php" : phpPath + "/user/add_like_comment.php";
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
    await fetch(phpPath + "/user/add_comment.php", {
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

export async function showComments(IDpost) {
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
        clone.querySelector("a").href = "/profile?user=" + comment.username_utente;
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


loadUserInformation(usernameURL);
showPost(0);