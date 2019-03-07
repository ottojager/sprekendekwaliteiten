function selectCard(element) {
    var text = element.innerText;

    if (selectedCards.includes(text)) {
        selectedCards = arrayRemove(selectedCards, text);
    }
    else {
        if (selectedCards.length >= 3) {
            alert("Je hebt het maximaal aantal kaarten bereikt! Als je liever een andere kaart wil selecteren, kun je eerst op een rode kaart klikken om die kaart te de-selecteren.");
            return;
        }
        selectedCards.push(text);
    }

    element.parentElement.classList.toggle('eind-kaart');
}

function confirmCardSelections() {
    if (selectedCards.length < 3) {
        alert("Het minimaal aantal kaarten is 3. Voeg nog " 
        + (3 - selectedCards.length) 
        + ((selectedCards.length == 1) ? " kaarten" : " kaart")
        + " toe om te kunnen beginnen.");
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // redirect to next window, it doesn't exist yet right now :(
        }
    };
    xhttp.open("POST", "../kernkwadranten/api/select.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(selectedCards));
}

function arrayRemove(arr, value) { //Thanks StackOverflow
    return arr.filter(function(ele){
        return ele != value;
    });
 }