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
        var calculatedIndex = (carouselIndex+counter)%activeCarousel.length;
        if (calculatedIndex < 0) {
            //Haha now hope no one bothers to overflow this integer :(
            calculatedIndex = activeCarousel.length + calculatedIndex;
        }
        carouselCards[i].innerText = activeCarousel[calculatedIndex].name;
        counter += toAdd;
    }	
}

function fillCarousel(empty = false) {
    carouselIndex = 0;
    var carouselCards = document.getElementsByClassName('carousel-card-text');

    for (var i = 0; i < carouselCards.length; i++) {
        carouselCards[i].innerText = !empty ? activeCarousel[i].name : "";
    }
}

function nextKwadrantPick(element) {
    if (currentKwadrantIndex < 4) {
        try {
            toggleCardHighlight(currentKwadrantIndex);

            var currentKernkwaliteit = playerKwaliteiten[indices[currentKernkwaliteitIndex]];
            var word = element.getElementsByClassName("carousel-card-text")[0];
            console.log(element);
            currentKernkwaliteit[cardTypes[currentKwadrantIndex]] = word.innerText;
            document.getElementById(ids[currentKwadrantIndex]).innerText = word.innerText;
            toggleCardHighlight(++currentKwadrantIndex);

            document.getElementById("kwadrantQuestion").innerText = questions[currentKwadrantIndex];
            activeCarousel = currentKwadrantIndex % 2 != 0 ? allValkuilen : allKwaliteiten;
            fillCarousel();
        }
        catch (e) { 
            if (currentKernkwaliteitIndex < 2) {
                fillCarousel(true);
                toggleButtons(false);
                document.getElementById("kwadrantQuestion").innerText = FINISH_KWADRANT;
                currentKernkwaliteitIndex++;
            }
            else {
                endGame();
            }
         }
    }
}

function toggleButtons(visible) {
    var elements = document.getElementsByClassName("move-cards-button");

    for (var index = 0; index < elements.length; index++) {
        elements[index].style.display = visible ? "inline-block" : "none";
    }
}

function startGame() {
    if (currentKwadrantIndex == -1 || currentKwadrantIndex == 4) {
        currentKwadrantIndex = 1;
        setGameText("currentCardTitle", currentKernkwaliteitIndex);
        setGameText("kernkwaliteitCard", currentKernkwaliteitIndex);
        toggleCardHighlight(1);
        toggleButtons(true);

        for (var index = 1; index < 4; index++) {
            console.log(ids[index]);
            document.getElementById(ids[index]).innerText = "";
        }

        document.getElementById("kwadrantQuestion").innerText = questions[1];
        fillCarousel();
    }
    else {
        alert("Je huidige kernkwadrant is nog niet af!");
    }
}

function endGame() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = './overview.php';
        }
    };
    xhttp.open("POST", "../kernkwadranten/api/end.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(playerKwaliteiten));
}
//TODO: think we now only need to be able to move onto the next kernkwadrant, then add some summary kind of page, and then.. implement this into the other gamemodes