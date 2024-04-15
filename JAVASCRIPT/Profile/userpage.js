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
    let photosDiv = document.getElementById("photos");
    let template = document.getElementById("template-photos");
    if (loadedPosts.length == 0) {
        console.log("No posts to show");
    } else {
        if(type === 0){
            let dim = 0;
            let loadedPhoto;
            for (let photo_index = 0; photo_index < loadedPosts.length/2; photo_index++) {
                loadedPost = loadedPosts[photo_index];
                loadedPhoto = loadedPosts[photo_index + loadedPosts.length/2];
                let clone = document.importNode(template.content, true);
                clone.querySelector("#photo-id").src = "../../img/" + loadedPhoto.foto_video;
                clone.querySelector("#photo-id").alt = loadedPost.titolo;
                //clone.querySelector("#photo-id").addEventListener("click", function () { openModal(photo); });
                photosDiv.appendChild(clone);
                dim++;
            }
            let i = 0;
            if (dim % 3 == 1) {
                i = 2;
            } else if (dim % 3 == 2) {
                i = 1;
            }
            for (let j = 0; j < i; j++) {
                let clone = document.importNode(template.content, true);
                clone.querySelector("#photo-id").src = "../../img/default-user.webp";
                clone.querySelector("#photo-id").style.visibility = "hidden";
                photosDiv.appendChild(clone);
            }
        }
    }
}

showpost(0);