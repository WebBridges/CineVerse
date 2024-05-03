const phpPath = "../../PHP";

import { GetUsername } from "../Utils/utils.js";
import { loadLikes } from "../Utils/utils.js";
import { loadUserImage } from "../Utils/utils.js";
import { createSurveyElement } from "../Utils/utils.js";
import { getMedia } from "../Utils/utils.js";
import { like } from "../Utils/utils.js";
import { checkLike } from "../Utils/utils.js";
import { showComments } from "../Utils/utils.js";


const max_posts = 5;
let offset = 0;
let lastClickedID;
let click = 0;

const loadMorePostButton = document.getElementById("load-more-post-button");
loadMorePostButton.addEventListener("click", async function() {
    offset += 5;
    showHomePosts();
});

async function getHomePosts(user) {
    const response = await fetch(phpPath + "/Home/LoadAllFollowedPosts.php?user=" + user + "&max_posts=" + max_posts + "&offset=" + offset);
    const data = await response.json();
    return data;
}

async function showHomePosts() {
    const posts = await getHomePosts(await GetUsername());
    if (posts.length == 0) {
        loadMorePostButton.innerHTML = "No more posts to show";
        loadMorePostButton.disabled = true;
    };
    
    for (let i = 0; i < posts.length; i++) {
        const post = posts[i];
        const value = await getMedia(post.IDpost);
        const media = value.data;
        const type = value.type;

        const postsSection = document.getElementById("posts-section");
        const template = document.getElementById("template-posts");
        const clone = template.content.cloneNode(true);
        
        //Post header
        clone.querySelector(".post-title").innerHTML = post.titolo;
        const userImage = await loadUserImage(post.username_utente);
        if (userImage != null) {
            clone.querySelector(".post-user-photo").src = "../../img/" + userImage;
        }
        clone.querySelector(".post-username").innerHTML = post.username_utente;
        
        //Post body
        const postElement = clone.querySelector(".post-element");
        postElement.addEventListener("click", function() { checkDoubleClick(post.IDpost); });
        let element;
        if (type == "foto_video") {
            let split = media.foto_video.split(".");
            if (split[1] == "mp4") {
                element = document.createElement("video");
                element.src = "../../img/" + media.foto_video; //percorso del video
                element.controls = true; //Abilita i controlli del video
                element.autoplay = false;
                element.loop = false; 
                element.muted = false;
                element.className = 'img-fluid mx-auto d-block border border-black'; // Classe CSS
                element.id = 'post-video' + post.IDpost; // ID del video

                postElement.appendChild(element);
                clone.querySelector(".post-description").innerHTML = media.descrizione;
            } else {
                element = document.createElement("img");
                element.id = "post-photo" + post.IDpost;
                element.classList.add("img-fluid");
                element.src = "../../img/" + media.foto_video;
                postElement.appendChild(element);
                clone.querySelector(".post-description").innerHTML = media.descrizione;
            }
        } else if (type == "testo") {
            element = document.createElement("p");
            element.innerHTML = media.corpo;
            postElement.appendChild(element);
            clone.querySelector(".post-description").classList.add("invisible");
        } else if (type == "survey") {
            const element = await createSurveyElement(post, media)
            postElement.appendChild(element);
        }

        const liked = await checkLike(post.IDpost, GetUsername());
        const postActions = clone.querySelector(".post-actions");
        const likeButton = postActions.querySelector(".likes-button");
        likeButton.id = "likes-button" + post.IDpost;
        likeButton.addEventListener("click", function () { like(post.IDpost) });
        if (liked) {
            likeButton.innerHTML = "<em class='fa-solid fa-heart' style='color: #ff8500;'></em>";
        } else {
            likeButton.innerHTML = "<em class='fa-regular fa-heart' style='color: #ffffff;'></em>";
        }

        clone.querySelector(".comments-button").addEventListener("click", function() { showComments(post.IDpost); });

        //Post footer
        const nLikes = clone.querySelector(".post-count-likes");
        nLikes.id = "post-count-likes" + post.IDpost;
        nLikes.innerHTML = await loadLikes(posts[i].IDpost);
        postsSection.appendChild(clone);
    }
}

function checkDoubleClick(postID) {
    if (lastClickedID != postID) {
        lastClickedID = postID;
        click = 1;
        resetClick(333);
    } else {
        if (click == 1) {
            click = 0;
            like(postID);
        } else {
            click = 1;
            resetClick(333);
        }
    }
}

function resetClick(timeout) {
    setTimeout(function(){
        click = 0;
    }, timeout);
}


showHomePosts();