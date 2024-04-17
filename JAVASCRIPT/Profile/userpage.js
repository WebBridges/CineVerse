const phpPath = "../../PHP";

const openOptionsButtons = document.getElementById("openbtn");
const closeOptions = document.getElementById("closebtn");
openOptionsButtons.addEventListener("click", function () { openSideBar(); });
closeOptions.addEventListener("click", function () { closeSideBar(); });

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

/**
 * All function to load posts
 * 
 */

async function loadPhotos() {
    const response = await fetch(phpPath + "/user/load_posted_photos.php", {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        },
        credentials: "include"
    });
    const posts = await response.json();
    return posts
}

async function loadText() {
    const response = await fetch(phpPath + "/user/load_posted_text.php", {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        },
        credentials: "include"
    });
    const posts = await response.json();
    return posts;
}

async function loadSurvey() {
    const response = await fetch(phpPath + "/user/load_posted_survey.php", {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        },
        credentials: "include"
    });
    const posts = await response.json();
    return posts;
}

async function getType(type) {
    if(type === 0){
        posts = await loadPhotos();
    }else if(type === 1){
        posts = await loadText();
    }else if(type === 2){
        posts = await loadSurvey();
    }
    const returnarray = [];
    posts.forEach(element => {
        returnarray.push(element);
    });
    return returnarray;
}

async function showpost(type) {
    let loadedPosts = await getType(type);
    let loadedPost = loadedPosts[0];
    let postsContainerDiv = document.getElementById("post-container");
    if (loadedPosts.length == 0) {
        console.log("No posts to show");
    } else {
        if(type === 0){
            let dim = 0;
            let loadedMedia;
            for (let photo_index = 0; photo_index < loadedPosts.length/2; photo_index++) {
                loadedPost = loadedPosts[photo_index];
                loadedMedia = loadedPosts[photo_index + loadedPosts.length/2];
                path = loadedMedia.foto_video;
                split = path.split(".");
                if (split[1] == "mp4") {
                    var container = document.createElement('div');
                    var video = document.createElement('video');
                    var img = document.createElement('img');
                    container.classList.add('video-container');

                    // Immagine che indica un video
                    img.alt = 'play-icon-identifier';
                    img.src = "../../img/play_button.WEBP";
                    img.className = 'play-icon';
                    
                    //Impostazione degli attributi del video
                    video.src = "../../img/" + path; //percorso del video
                    video.controls = true; //Abilita i controlli del video
                    video.autoplay = false;
                    video.loop = false; 
                    video.muted = false;
                    video.className = 'img-fluid mx-auto d-block border border-black'; // Classe CSS
                    video.id = 'video-id'; // ID del video
                
                    //Inserimento degli elementi nell'html
                    container.appendChild(video);
                    container.appendChild(img);
                    postsContainerDiv.appendChild(container);
                } else {
                    //Creazione dell'elemento immagine
                    var img = document.createElement('img');
                    img.alt = '';
                    img.className = 'img-fluid mx-auto d-block border border-black';
                    img.id = 'photo-id';
                    img.src = "../../img/" + path;
                    loadedPost
                    img.addEventListener("click", function (post, media) { 
                        return function() {
                            openModalPostPhoto(post, media);
                        }; 
                    }(loadedPost, loadedMedia));
                    //Inserimento dell'elemento immagine nell'html
                    postsContainerDiv.appendChild(img);
                }
                dim++;
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
    if (username == null) {
        const response = await fetch(phpPath + "/user/check_post_like.php?IDpost=" + IDpost);
        const liked = await response.json();
        return liked;
    } else {
        const response = await fetch(phpPath + "/user/check_post_like.php?IDpost=" + IDpost + "&username=" + username);
        const liked = await response.json();
        return liked;
    }
}

async function openModalPostPhoto(post, photo) {
    const postActions = document.getElementById("post-actions");
    const liked = await checkLike(post.IDpost, null);
    // clean buttons event listeners
    document.getElementById("comments-button").replaceWith(document.getElementById("comments-button").cloneNode(true));
    document.getElementById("likes-button").replaceWith(document.getElementById("likes-button").cloneNode(true));
    // show modal
    document.getElementById("post-user-photo").src = "../../img/" + await loadUserImage(post.username_utente);
    document.getElementById("post-username").innerHTML = post.username_utente;
    document.getElementById("post-photo").src = "../../img/" + photo.foto_video;
    document.getElementById("post-count-likes").innerHTML = "Likes: " + await loadLikes(post.IDpost);
    document.getElementById("post-description").innerHTML = photo.descrizione;
    const likeButton = postActions.querySelector("#likes-button");
    //likeButton.addEventListener("click", function () { like(post.post_id, "post", !post.liked, document, "#likes-button", "#post-likes") });
    if (liked) {
        likeButton.innerHTML = "<em class='fa-solid fa-heart' style='color: #ff8500;'></em>";
    } else {
        likeButton.innerHTML = "<em class='fa-regular fa-heart'></em>";
    }
    //postActions.querySelector("#comments-button").addEventListener("click", function() { showComments(post.post_id); });
}

showpost(0);