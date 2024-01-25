const openOptionsButtons = document.getElementById("openbtn");
const closeOptions = document.getElementById("closebtn");
openOptionsButtons.addEventListener("click", function () { openSideBar(); });
closeOptions.addEventListener("click", function () { closeSideBar(); });


function openSideBar() {
    document.getElementById("mySidebar").style.width = "250px";
}

function closeSideBar() {
    document.getElementById("mySidebar").style.width = "0";
}