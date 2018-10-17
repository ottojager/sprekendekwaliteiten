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
        document.getElementById(i.toString()).addEventListener('click', function() {
			reply_click(this.id);
		});
    }
	// document.getElementById("trash").addEventListener('click', function() {
	// 		reply_click(this.id);
	// 		window.scrollTo(0,document.body.scrollHeight);
	// 	});
	// document.getElementById("skiplink").addEventListener('click', function() {
	// 		window.scrollTo(0,0);
	// 	});
}

function send_email() {
    var email = document.getElementById('email').value;
    var pattern = /[^@]*@[^@]*\..{2,}/;
    var match = pattern.test(email);
    var p = document.getElementById('error');
    if (!match) {
        p.innerHTML = 'Het ingevulde email adres klopt niet';
        exit();
    } else {
        p.innerHTML = '';
    }

    var cards = "";
    var i;
    for (i = 1; i < 9; i += 1) {
        cards += hand[i] + ",";
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // alert('De e-mail is verstuurd.');
            // document.getElementById('email').value = '';
            // document.location.href= '../';
            document.getElementById('main').innerHTML = '';
            var p = document.createElement('p');
            p.innerHTML = "Het bericht is verzonden naar uw email.";
            p.classList.add('success');
            document.getElementById('main').appendChild(p);
			
			//achtergrond links
            var backLeft = document.createElement('span');
            backLeft.classList.add('alienBackLeft');
            document.getElementById('main').appendChild(backLeft);
			
			//achtergrond rechts
            var backRight = document.createElement('span');
            backRight.classList.add('alienBackRight');
            document.getElementById('main').appendChild(backRight);
        }
    };
    xhttp.open("GET", "./mail.php?cards=" + cards + "&email=" + email, true);
    xhttp.send();
}

function reply_click(clicked_id) {
    "use strict";
    console.log(clicked_id);
    if (gameEnded == 0 && currentCard !== 0) {
        var i;
        lastChosenPosition.unshift(clicked_id);
        if (clicked_id !== "trash") {
            var card_text = document.getElementById(clicked_id).getElementsByTagName('p')[0].innerHTML
            if (confirm("Weet u zeker dat u "+card_text+" wilt vervangen?")) {
                // plaats actieve kaart in graveyard array
                graveyard.unshift(document.getElementById(clicked_id).firstChild.innerHTML);
                //vervang geselecteerde hand kaart met actieve kaart
                hand[Number(clicked_id)] = currentCard;
                document.getElementById(clicked_id).innerHTML = "<p>"+currentCard+"</p>";
                currentCard = 0;
                document.getElementById('card-heading-text').classList.add('switched')
                document.getElementById('current-card-holder').classList.add('switched');

                // allow the user to click the new card button
                document.getElementById("newCardButton").setAttribute('aria-disabled', false);
				document.getElementById("newCardButton").focus();
                document.getElementById("newCardButton").onclick = newCard;

                // do not allow the user to uuse the back button
                var backButton = document.getElementById("BackToNewCardViewButton")
                backButton.setAttribute('aria-disabled', true);
                backButton.onclick = function(){};

            }
        } else {
            //actieve kaart in graveyard doen
            graveyard.unshift(document.getElementById("current").innerHTML);
            newCard();
        }
        // graveyard reïninitaliseren
        // rewriteGraveyard();
        // nieuwe kaart pakken en in current slot doen

        // checken of de game eindigt
        if (cardStack.length === 0 && currentCard == null) {
            endGameHandView(true);
            alert("Je hebt alle kaarten gehad. Vul je email in en klik op \"Stuur email\" om de resultaten als email naar jezelf te stuuren.");
        }
    }
}

function backButton() {
    "use strict";
    if (graveyard.length > 0) {
        if (currentCard !== 0) {
            cardStack.unshift(currentCard);
        }

        if (lastChosenPosition[0] != "trash") {
            currentCard = hand[lastChosenPosition[0].toString()];
            hand[lastChosenPosition[0].toString()] = graveyard[0];
            graveyard.splice(0, 1);
        } else {
            currentCard = graveyard[0];
        }

        // update views
        if (view == 'currentCard') {
            newCardView();
        } else if (view == 'hand') {
            handViewTemp();
        } else if (view == 'trade') {
            handView();
        }
        document.getElementById("current").innerHTML = currentCard;
        lastChosenPosition.shift();
        graveyard.shift();
        rewriteGraveyard();
    }
}

function newCard() {
    "use strict";
    // pakt niewe kaart van de cardStack zet die als active card en gaat naar de new card view
    currentCard = takeCard();
    newCardView();
}

function newCardView() {
    view = 'currentCard';
    // ga naar de new card view
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var html = this.responseText.replace("card", currentCard);
            document.getElementById("main").innerHTML = html;
            document.getElementById("trash").addEventListener('click', function() {
        			reply_click(this.id);
        			window.scrollTo(0,document.body.scrollHeight);
        	});
            document.title = 'Nieuwe kaart - Bewustwording - Sprekende Kwaliteiten';
        }
    };
    xhttp.open("GET", "./parts/newcard.html", true);
    xhttp.send();
}

function handView() {
    view = 'trade'
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // lots o' replaces
            var html = this.responseText
            .replace("active card", currentCard)
            .replace("card1", hand[1])
            .replace("card2", hand[2])
            .replace("card3", hand[3])
            .replace("card4", hand[4])
            .replace("card5", hand[5])
            .replace("card6", hand[6])
            .replace("card7", hand[7])
            .replace("card8", hand[8]);
            document.getElementById("main").innerHTML = html;
            // add click event listeners zodat we kunnen zien welke kaart geslecteerd woord
            addListeners();
            document.title = 'Ruil je kaart - Bewustwording - Sprekende Kwaliteiten';
        }
    };
    xhttp.open("GET", "./parts/inruilen.html", true);
    xhttp.send();
}

function handViewTemp() {
    view = 'hand';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // lots o' replaces
            var html = this.responseText
            .replace("active card", currentCard)
            .replace("card1", hand[1])
            .replace("card2", hand[2])
            .replace("card3", hand[3])
            .replace("card4", hand[4])
            .replace("card5", hand[5])
            .replace("card6", hand[6])
            .replace("card7", hand[7])
            .replace("card8", hand[8]);
            document.getElementById("main").innerHTML = html;

            document.title = 'Hand kaarten - Bewustwording - Sprekende Kwaliteiten';
        }
    };
    xhttp.open("GET", "./parts/hand_overview.html", true);
    xhttp.send();
}

function endGameHandView(no_confirm) {
    if (no_confirm || confirm('Weet u zeker dat u het spel wil beëindigen?')) {
        // no swaping card if the game ended
        gameEnded = 1;

        // change title
        document.title = 'Einde - Bewustwording - Sprekende Kwaliteiten';

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // lots o' replaces
                var html = this.responseText
                .replace("active card", currentCard)
                .replace("card1", hand[1])
                .replace("card2", hand[2])
                .replace("card3", hand[3])
                .replace("card4", hand[4])
                .replace("card5", hand[5])
                .replace("card6", hand[6])
                .replace("card7", hand[7])
                .replace("card8", hand[8]);
                document.getElementById("main").innerHTML = html;
            }
        };
        xhttp.open("GET", "./parts/endgame_hand.html", true);
        xhttp.send();
    }
}

function endGameEmailView() {
    // change title
    document.title = 'Email - Bewustwording - Sprekende Kwaliteiten';

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("main").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "./parts/endgame_email.html", true);
    xhttp.send();
}

// een paar default values ininitaliseren
var currentCard = '';
var hand = [];
var graveyard = [];
var lastChosenPosition = [];
var gameEnded = 0;
var view = 'currentCard';

// kaarten schudden
shuffle(cardStack);

// 8 handkaarten neerleggen
var i;
for (i = 1; i < 9; i += 1) {
    // document.getElementById("slot" + i.toString()).getElementsByTagName('p')[0].innerHTML = takeCard();
    hand[i] = takeCard();
}

// eerste kaart pakken en in active slot doen
newCard();
