//versie 0.1
function shuffle(a) {
    "use strict";
    var j, x, i;
    for (i = a.length; i; i -= 1) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}
function takeCard() {
    "use strict";
    var takenCard = cardStack[0];
    cardStack.shift();
    return takenCard;
}
function fillSlots() {
    "use strict";
    var i;
    for (i = 1; i < 9; i += 1) {
        document.getElementById("slot" + i.toString()).innerHTML = takeCard();
    }
}
function rewriteGraveyard() {
    "use strict";
    var i;
    document.getElementById("graveyard").innerHTML = "Graveyard?<br>";
    for (i = 0; i < graveyard.length; i += 1) {
        document.getElementById("graveyard").innerHTML += graveyard[i] + "<br>";
    }
}

function addListeners() {
	"use strict";
	var i;
    for (i = 1; i < 9; i += 1) {
        document.getElementById("slot" + i.toString()).addEventListener('click', function() {
			reply_click(this.id);
		});
    }
	document.getElementById("graveyard").addEventListener('click', function() {
			reply_click(this.id);
		});
}

addListeners();

var graveyard = [];
var lastChosenPosition = [];
//kaarten schudden
shuffle(cardStack);
//8 handkaarten neerleggen
fillSlots();
//eerste kaart pakken en in active slot doen
var currentCard = takeCard();
document.getElementById("current").innerHTML = currentCard;

function reply_click(clicked_id) {
    "use strict";
    var i;
    lastChosenPosition.unshift(clicked_id);
    if (clicked_id !== "graveyard") {
        //plaats actieve kaart in graveyard array
        graveyard.unshift(document.getElementById(clicked_id).innerHTML);
        //vervang geselecteerde hand kaart met actieve kaart
        document.getElementById(clicked_id).innerHTML = currentCard;
    } else {
        //actieve kaart in graveyard doen
        graveyard.unshift(document.getElementById("current").innerHTML);
    }
    //graveyard reïninitaliseren
    rewriteGraveyard();
    //nieuwe kaart pakken en in current slot doen
    currentCard = takeCard();
    document.getElementById("current").innerHTML = currentCard;
    //checken of de game eindigt
    if (cardStack.length === 0 && currentCard == null) {
		//top leegmaken
		document.getElementById("top").innerHTML = "";
		//button naar pdf toevoegen
		var btn = document.createElement("button");
    	btn.innerHTML = "download PDF";
		btn.id ='pdf';
		document.getElementById("top").appendChild(btn);
		//listener aan button geven
		document.getElementById("pdf").addEventListener('click', function() {
			var cards = "";
			var i;
    		for (i = 1; i < 9; i += 1) {
        		cards += document.getElementById("slot" + i.toString()).innerHTML + ",";
    		}
			window.location.href = 'pdf.php?cards=' + cards;
		});
						 
        alert("Je hebt alle kaarten gehad. Klik op 'download PDF' om je resultaten te downloaden.");
    }
}
function backButton() {
    "use strict";
    //var lastCard = document.getElementById(lastChosenPosition[0]).innerHTML;
    if (lastChosenPosition[0] !== "graveyard") {
        cardStack.unshift(document.getElementById("current").innerHTML);
        currentCard = document.getElementById(lastChosenPosition[0]).innerHTML;
        document.getElementById("current").innerHTML = document.getElementById(lastChosenPosition[0]).innerHTML;
        document.getElementById(lastChosenPosition[0]).innerHTML = graveyard[0];
        lastChosenPosition.shift();
        graveyard.shift();
    } else if (graveyard.length !== 0) {
        cardStack.unshift(document.getElementById("current").innerHTML);
        document.getElementById("current").innerHTML = graveyard[0];
        currentCard = graveyard[0];
        graveyard.shift();
    }
    rewriteGraveyard();
}
