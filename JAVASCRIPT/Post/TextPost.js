document.getElementById("FormPostText").addEventListener('submit', function(event) {
    event.preventDefault();

    let errors = document.getElementsByClassName('error-message');
    for(let i = 0; i < errors.length; i++) {
        errors[i].style.display = 'none';
    }
    var title = document.getElementById('postTitle').value;
    var description = document.getElementById('postDescription').value;

    if(title === "") {
        document.getElementById('errorTitle').style.display = 'block';
        return;
    } else if (description === ""){
        document.getElementById('errorDescription').style.display = 'block';
        return;
    } else {
        event.target.submit();

    }
});