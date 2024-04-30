const phpPath = "../../PHP";

import { GetUsername } from "../Utils/utils.js";
import { loadLikes } from "../Utils/utils.js";
import { loadUserImage } from "../Utils/utils.js";
import { createSurveyElement } from "../Utils/utils.js";
import { getMedia } from "../Utils/utils.js";


let max_posts = 10;

async function getHomePosts(user) {
    const response = await fetch(phpPath + "/Home/LoadAllFollowedPosts.php?user=" + user + "&max_posts=" + max_posts);
    const data = await response.json();
    return data;
}

async function showHomePosts() {
    const posts = await getHomePosts(await GetUsername());
    console.log(posts);
    for (let i = 0; i < posts.length; i++) {
        const post = posts[i];
        const value = await getMedia(post.IDpost);
        const media = value.data;
        const type = value.type;
        console.log(media, type);

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
        const postElement = clone.querySelector(".post-element");
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

        clone.querySelector(".post-element")
        clone.querySelector(".post-count-likes").innerHTML = await loadLikes(posts[i].IDpost);
        postsSection.appendChild(clone);
    }
}



showHomePosts();