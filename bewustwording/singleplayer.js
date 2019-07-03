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
    if (cardStack.length > 0) {
    var takenCard = cardStack[0].name;
    cardStack.shift();
    return takenCard;
    }
    return undefined;
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
        return
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

            // succ text
            var p = document.createElement('p');
            p.innerHTML = "Het bericht is verzonden naar jouw e-mail adres.";
            p.classList.add('success');

            // back button
            var back_button = document.createElement('button');
            back_button.innerHTML = 'Terug naar Home';
            back_button.onclick = function() {
                window.location = '../index.php';
            }
            var back_button_div = document.createElement('div');
            back_button_div.classList.add('button');
            back_button_div.appendChild(back_button);

            var back_div_button_div_div = document.createElement('div');
            back_div_button_div_div.classList.add('bottom-menu');
            back_div_button_div_div.appendChild(back_button_div);

            var kwadrantDiv = document.createElement('div');
            kwadrantDiv.classList.add('button');
            var kwadrantBtn = document.createElement('button');
            kwadrantBtn.innerText = "Maak kernkwadranten";
            kwadrantBtn.onclick = startGameMode4;
            kwadrantDiv.appendChild(kwadrantBtn);
            back_div_button_div_div.appendChild(kwadrantDiv);

            document.getElementById('main').appendChild(p);
            document.getElementById('main').appendChild(back_div_button_div_div);

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
    if (gameEnded == 0 && currentCard !== 0) {
        var i;
        lastChosenPosition.unshift(clicked_id);
        if (clicked_id !== "trash") {
            var card_text = document.getElementById(clicked_id).getElementsByTagName('p')[0].innerHTML
            if (confirm("Weet je zeker dat je "+card_text+" wil vervangen?")) {
                // plaats actieve kaart in graveyard array
                graveyard.unshift(document.getElementById(clicked_id).firstChild.innerHTML);
                //vervang geselecteerde hand kaart met actieve kaart
                hand[Number(clicked_id)] = currentCard;
                document.getElementById(clicked_id).innerHTML = "<p>"+currentCard+"</p>";
                currentCardString = currentCard;
                currentCard = 0;
                document.getElementById('card-heading-text').classList.add('switched')
                document.getElementById('current-card-holder').classList.add('switched');

                // allow the user to click the new card button
                document.getElementById("newCardButton").setAttribute('aria-disabled', false);
				document.getElementById("newCardButton").focus();
				document.getElementById("newCardButton").onclick = newCard;

                // do not allow the user to use the back button
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
            alert("Je hebt alle kaarten gehad. Vul je e-mail adres in en klik op \"Stuur e-mail\" om de resultaten als e-mail naar jezelf te sturen.");
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
    }
}

function newCard() {
    "use strict";
    // pakt niewe kaart van de cardStack zet die als active card en gaat naar de new card view
    currentCard = takeCard();
    currentCardString = currentCard;
    newCardView();
}

function newCardView() {
    view = 'currentCard';
    // ga naar de new card view
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("main").innerHTML = this.responseText.replace("card", currentCard);
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

function replaceCards(html) {
    html = html.replace("active card", currentCard);

    for (var i = 1; i < 9; i++) {
        html = html.replace("card" + i.toString(), hand[i]);
    }

    return html;
}

function handView() {
    view = 'trade'
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // lots o' replaces
            document.getElementById("main").innerHTML = replaceCards(this.responseText);
            // add click event listeners zodat we kunnen zien welke kaart geselecteerd wordt 
            addListeners();
            document.title = 'Ruil je kaart - Bewustwording - Sprekende Kwaliteiten';
        }
    };
    xhttp.open("GET", "./parts/inruilen.html", true);
    xhttp.send();
	// Nadat part "inruilen.html" is geladen toont de browser na 1000 miliseconden een alert met instructie.
	setTimeout(function() {
		alert("Jouw nieuwe kaart is "+currentCardString+". Je kunt één van je 8 handkaarten vervangen door "+currentCardString);
		document.getElementById("1").focus(); // 1e kaart van de handkaarten krijgt focus.
	}, 1000);
}

function handViewTemp() {
    view = 'hand';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // lots o' replaces
            document.getElementById("main").innerHTML = replaceCards(this.responseText);

            document.title = 'Hand kaarten - Bewustwording - Sprekende Kwaliteiten';
        }
    };
    xhttp.open("GET", "./parts/hand_overview.html", true);
    xhttp.send();
}

function endGameHandView(no_confirm) {
    if (no_confirm || confirm('Weet je zeker dat u het spel wil beëindigen?')) {
        // no swapping card if the game ended
        gameEnded = 1;

        // change title
        document.title = 'Einde - Bewustwording - Sprekende Kwaliteiten';

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // lots o' replaces
                document.getElementById("main").innerHTML = replaceCards(this.responseText);
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
            document.getElementById('email').focus();
        }
    };
    xhttp.open("GET", "./parts/endgame_email.html", true);
    xhttp.send();
}

function startGameMode4() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = '../kernkwadranten/getstarted.php';
        }
    };
    xhttp.open("POST", "../kernkwadranten/api/new.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(hand));
}

// een paar default values initialiseren
var currentCard = '';
var hand = [];
var graveyard = [];
var lastChosenPosition = [];
var gameEnded = 0;
var view = 'currentCard';
var currentCardString = '';

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
