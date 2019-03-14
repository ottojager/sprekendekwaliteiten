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
            window.location.href = './game.php';
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

 function setGameText(id, index) {
    document.getElementById(id).innerText = indices[index];
 }

 function toggleCardHighlight(index) {
    document.getElementById(ids[index]).parentElement.parentElement.classList.toggle("kwadrant-highlight");
 }

function moveCarousel(positive = true) {
    var toAdd = positive ? 1 : -1;
    var carouselCards = document.getElementsByClassName('carousel-card-text');
    carouselIndex += carouselCards.length * toAdd;
    var counter = 0;
    for (var i = 0; i < carouselCards.length; i++) {
        carouselCards[i].innerText = activeCarousel[(carouselIndex+counter)%activeCarousel.length].name;
        counter += toAdd;
    }	
}

function fillCarousel() {
    carouselIndex = 0;
    var carouselCards = document.getElementsByClassName('carousel-card-text');

    for (var i = 0; i < carouselCards.length; i++) {
        carouselCards[i].innerText = activeCarousel[i].name;
    }
}

function startGame() {
    setGameText("currentCardTitle", currentKernkwaliteitIndex);
    setGameText("kernkwaliteitCard", currentKernkwaliteitIndex);
    fillCarousel();
}
//TODO: add buttons for carousel, add buttons that let you select valkuil, then move on to uitdaging and allergie