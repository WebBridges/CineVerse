document.addEventListener('DOMContentLoaded', (event) => {
    loadTopicCheckboxes();
});

function loadTopicCheckboxes(){
    fetch("../../JSON/TopicTag.json")
        .then(response => {
             if (!response.ok) {
                     throw new Error("HTTP error " + response.status);
                }
            return response.json();
    })
    .then(data => {
        let checkboxHTML = '';
        // Utilizza i dati del file JSON per generare l'HTML dei bottoni
        for(let i = 0; i < data.topic.length; i++) {
            //checkboxHTML += `<li><input type="checkbox" id="${data.topic[i].id}" name="${data.topic[i].name}" value="${data.topic[i].id}"><label for="${data.topic[i].id}">${data.topic[i].label}</label></li>`;
              checkboxHTML+=`<div class="form-check">
                                <input class="form-check-input" type="checkbox" id="${data.topic[i].id}" name="${data.topic[i].name}" value="${data.topic[i].id}">
                                <label class="form-check-label" for="${data.topic[i].id}">
                                    ${data.topic[i].label}
                                </label>
                                </div>
                            `
        }
        document.getElementById('TopicList').innerHTML = checkboxHTML;
        document.querySelectorAll("input[type='checkbox']").forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                // Controlla il numero di checkbox selezionate
                let checkedCount = document.querySelectorAll("input[type='checkbox']:checked").length;
                if(checkedCount > 5) {
                    // Se ci sono più di 5 checkbox selezionate, deseleziona l'ultima checkbox selezionata
                    this.checked = false;
                }
            });
        });
    })
    .catch(function() {
        console.log("An error occurred while fetching the JSON data.");
    });
}

function unselectRadioButton() {
    var radioButtons = document.getElementsByName('gender');
    for (var i = 0; i < radioButtons.length; i++) {
        // Aggiungi l'event listener solo se non è già stato aggiunto
        if (!radioButtons[i].hasClickListener) {
            radioButtons[i].addEventListener('mousedown', function() {
                if (this.checked && this.wasChecked) {
                    e.preventDefault();
                    this.checked = false;
                }
                this.wasChecked = this.checked;
            });
            // Segna il radiobutton come avente un event listener
            radioButtons[i].hasClickListener = true;
        }
    }
}
