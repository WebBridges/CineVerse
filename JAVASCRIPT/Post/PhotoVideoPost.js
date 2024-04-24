document.getElementById("FormPostPhotoVideo").addEventListener('submit', function(event) {
    event.preventDefault();

    let errors = document.getElementsByClassName('error-message');
    for(let i = 0; i < errors.length; i++) {
        errors[i].style.display = 'none';
    }

    var title = document.getElementById('postTitle').value;
    var description = document.getElementById('postDescription').value;
    var fileInput = document.getElementById('uploadFile');
    var file = fileInput.files[0];

    if(title === "") {
        document.getElementById('errorTitle').style.display = 'block';
        return;
    } else if (description === ""){
        document.getElementById('errorDescription').style.display = 'block';
        return;
    } else if (fileInput.files.length === 0) {
        document.getElementById('errorFile').style.display = 'block';
        return;
    } else if (!file.type.startsWith('image/') && !file.type.startsWith('video/')) {
        document.getElementById('errorFile').style.display = 'block';
        return;
    } else {
        event.target.submit();
    }
});