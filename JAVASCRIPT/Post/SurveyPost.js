document.getElementById('addField').addEventListener('click', function() {
    var field3 = document.getElementById('field3');
    var field4 = document.getElementById('field4');

    if (field3.hasAttribute('hidden')) {
        field3.removeAttribute('hidden');
    } else if (field4.hasAttribute('hidden')) {
        field4.removeAttribute('hidden');
    }
});

document.getElementById('removeField').addEventListener('click', function() {
    var field4 = document.getElementById('field4');
    var field3 = document.getElementById('field3');

    if (!field4.hasAttribute('hidden')) {
        field4.setAttribute('hidden', true);
    } else if (!field3.hasAttribute('hidden')) {
        field3.setAttribute('hidden', true);
    }
});

document.getElementById("FormPostSurvey").addEventListener('submit', function(event) {
    event.preventDefault();

    let errors = document.getElementsByClassName('error-message');
    for(let i = 0; i < errors.length; i++) {
        errors[i].style.display = 'none';
    }
    var title = document.getElementById('postTitle').value;
    var field1 = document.getElementById('field1').value;
    var field2 = document.getElementById('field2').value;
    var field3 = document.getElementById('field3');
    var field4 = document.getElementById('field4');

    if(title === "") {
        document.getElementById('errorTitle').style.display = 'block';
        return;
    }

    if(field1 === "" || field2 === ""){
        document.getElementById('errorField').style.display = 'block';
        return;
    } else if(!field3.hasAttribute('hidden') && field3.value === "") {
        document.getElementById('errorField').style.display = 'block';
        return;
    } else if(!field4.hasAttribute('hidden') && field4.value === "") {
        document.getElementById('errorField').style.display = 'block';
        return;
    } else {
        event.target.submit();
    }
});