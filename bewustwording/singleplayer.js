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
        document.getElementById("slot" + i.toString()).getElementsByTagName('p')[0].innerHTML = takeCard();
    }
}
function rewriteGraveyard() {
    "use strict";
    var i;
    var garbage_pile = document.getElementById("graveyard"); //TODO: rename to something better than garbage_pile
    garbage_pile.innerHTML = ""; // empty the list
    /*var head_li = document.createElement('li');
    var head = document.createElement('h2');
	var head_button = document.createElement('button');
    head.innerHTML = "Aflegstapel";
	head_button.appendChild(head);
    head_li.appendChild(head_button);
    garbage_pile.appendChild(head_li);*/

    for (i = 0; (i < graveyard.length); i += 1) { // do a max of 3 items otherwise do all
        if (i == 3) {
            break;
        }
        var item = document.createElement('li');
        item.innerHTML = graveyard[i];
        garbage_pile.appendChild(item);

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
	document.getElementById("trash").addEventListener('click', function() {
			reply_click(this.id);
			window.scrollTo(0,document.body.scrollHeight);
		});
	document.getElementById("skiplink").addEventListener('click', function() {
			window.scrollTo(0,0);
		});
}

function endGame(no_confirm) {
    if (no_confirm || confirm('Weet u zeker dat u het spel wil beëindigen?')) {
        gameEnded = 1;
        //top leegmaken
        document.getElementById("actievekaart").innerHTML = "";

        // container div
        var div = document.createElement('div');

        //input field for email
        var email = document.createElement('input');
        email.id = 'email';
        email.type = 'email';
        var label = document.createElement('label');
        label.innerHTML = 'E-mail';
        label.htmlFor = 'email';
        div.appendChild(label);
        div.appendChild(email);
        var btn = document.createElement('button');
        btn.onclick = function() {
            var email = document.getElementById('email').value;
            var pattern = /[^@]*@[^@]*\..{2,}/;
            var match = pattern.test(email);
            var p = document.getElementById('error');
            if (!match) {
                p.innerHTML = 'Het ingevulde email adderess klopt niet';
                exit();
            } else {
                p.innerHTML = '';
            }

            var cards = "";
            var i;
            for (i = 1; i < 9; i += 1) {
                cards += document.getElementById("slot" + i.toString()).innerHTML + ",";
            }

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
                    alert('De e-mail is verstuurd.');
                    email.value = '';
				}
			};
			xhttp.open("GET", "./mail.php?cards=" + cards + "&email=" + email, true);
			xhttp.send();
        }
        btn.innerHTML='Stuur e-mail';
        div.appendChild(btn);
        // for later adding error messages
        var p = document.createElement('p');
        p.id = 'error';
        div.appendChild(p);
        document.getElementById("actievekaart").appendChild(div);
        if (typeof no_confirm === undefined) {
            alert("Je hebt alle kaarten gehad. Vul je email in en klik op \"Stuur email\" om de resultaten als email naar jezelf te stuuren.");
        }
    }

}

addListeners();

var graveyard = [];
var lastChosenPosition = [];
var gameEnded = 0;
//kaarten schudden
shuffle(cardStack);
//8 handkaarten neerleggen
fillSlots();
//eerste kaart pakken en in active slot doen
var currentCard = takeCard();
document.getElementById("current").innerHTML = currentCard;

function reply_click(clicked_id) {
    "use strict";
    if (gameEnded == 0) {
        var i;
        lastChosenPosition.unshift(clicked_id);
        if (clicked_id !== "trash") {
            //plaats actieve kaart in graveyard array
            graveyard.unshift(document.getElementById(clicked_id).innerHTML);
            //vervang geselecteerde hand kaart met actieve kaart
            document.getElementById(clicked_id).getElementsByTagName('p')[0].innerHTML = currentCard;
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
	           endGame(true);
        }
    }
}
function backButton() {
    "use strict";
    //var lastCard = document.getElementById(lastChosenPosition[0]).innerHTML;
    if (lastChosenPosition[0] !== "trash") {
        cardStack.unshift(document.getElementById("current").innerHTML);
        currentCard = document.getElementById(lastChosenPosition[0]).firstChild.innerHTML;
        document.getElementById("current").innerHTML = document.getElementById(lastChosenPosition[0]).firstChild.innerHTML;
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
