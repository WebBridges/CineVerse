fetch("../../JSON/TopicTag.json")
  .then(response => {
    if (!response.ok) {
      throw new Error("HTTP error " + response.status);
    }
    return response.json();
  })
  .then(data => {
    let buttonsHTML = '';
    // Utilizza i dati del file JSON per generare l'HTML dei bottoni
    for(let i = 0; i < data.topic.length; i++) {
        buttonsHTML += `<li><button class="${data.topic[i].class}" name="${data.topic[i].name}" id="${data.topic[i].id}">${data.topic[i].label}</button></li>`;
    }
    document.getElementById('topic_button').innerHTML = buttonsHTML;
  })
  .catch(function() {
    console.log("An error occurred while fetching the JSON data.");
  });
