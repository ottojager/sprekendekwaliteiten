function reply_click(clicked_id) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "./api/game_logic.php?sel=" + clicked_id, true);
	xhttp.send();
	start_update();
}

function addListeners(amount_players) {
	"use strict";
	var i;
	for (i = 0; i <  amount_players; i += 1) {
		document.getElementById(i.toString()).addEventListener('click', function() {
			reply_click(this.id);
		});
	}
}

function start_update() {
	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
	 		//document.getElementById("main").innerHTML = this.responseText;
		 	game_info = JSON.parse(this.responseText);
		} else if (this.readyState == 4 && this.status == 204) {
			window.location.href = './delete.php'; // redirect users to delete.php to have session cleared
		}
  	};
	xhttp.open("GET", "./api/check.php", true);
	xhttp.send();
}

function undo() {
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "./api/undo.php");
	xhttp.send();
};

function leader_card(amount_players) {
	"use strict";
	var i;
	for (i = 0; i <  amount_players; i += 1) {
		document.getElementById(i.toString()).addEventListener('click', function() {
			leader_view_cards(this.id);
		});
	}
}

function leader_view_cards(id_player) {
	selected_player = id_player;
	var div = document.getElementById('card_stack');
	div.innerHTML = '';

	var name = document.createElement('p');
	name.innerHTML = game_info['players'][id_player]['name'];
	var list = document.createElement('ul');
	game_info['players'][id_player]['stack'].forEach(function(item, index){
		var child = document.createElement('li');
		child.innerHTML = item;
		list.appendChild(child);
	});

	div.appendChild(name);
	div.appendChild(list);
}

function help_window() {
	var name = game_info['players'][ game_info['current_player'] ]['name'];
	var content = name + ' is aan de beurt. ' + name + ' selecteert in de lijst spelers een naam aan wie hij/zij de kwaliteit wil geven';
	alert(content);
}

function update_view() {
	if (view == 'current'){
		current_card_view();
	} else if (view == 'recieved') {
		recieved_cards_view();
	} else if (view == 'leader'){
		leader_view();
	}
}

function current_card_view() {
	view = 'current';

	// get container element & clear it
	var container = document.getElementById('main');
	container.innerHTML = '';

	// create current card element
	card_display = document.createElement('div');
	card_display.id = 'card_display';
	card_active = document.createElement('p');
	card_active.id = 'current_card';
	card_active.innerHTML = game_info['current_card'];
	card_display.appendChild(card_active);

	// create the player list
	// let's just forget sorting right now
	var ul = document.createElement('ul');
	ul.id = 'player_list';
	game_info['players'].forEach(function(player){
		if (player['name'] != 'Afval stapel') {
			var li = document.createElement('li');
			li.id = player['player_id'];
			var button = document.createElement('button');
			var button_div = document.createElement('div');
			button_div.classList.add('player-button');
			button.innerHTML = player['name']+' ('+player['stack'].length+')';
			button_div.appendChild(button);
			li.appendChild(button_div);
			ul.appendChild(li);
		}
	});

	// graveyard "button"
	var graveyard = document.createElement('button');
	graveyard_div = document.createElement('div');
	graveyard_div.classList.add('button');
	graveyard.innerHTML = 'Afval stapel';
	graveyard.id = game_info['players'].length-1;
	graveyard_div.appendChild(graveyard);
	// graveyard.onclick =

	// recieved cards view button
	var button = document.createElement('button');
	var button_div = document.createElement('div');
	button_div.classList.add('button');
	button.innerHTML = 'Ontvangen kaarten';
	button.onclick = received_cards_view;
	button_div.appendChild(button);

	container.appendChild(card_display);
	container.appendChild(ul);
	container.appendChild(graveyard_div);
	container.appendChild(button_div);
	addListeners(game_info['players'].length);
}

function received_cards_view() {
	view = 'received';
	// get container element & clear it
	container = document.getElementById('main');
	container.innerHTML = '';

	// create card list
	var ul = document.createElement('ul')
	game_info['players'][own_id]['stack'].forEach(function(card){
    	var li = document.createElement('li');
    	var p = document.createElement('p');
    	p.innerHTML = card;
    	li.appendChild(p);
    	ul.appendChild(li);
	});
	container.appendChild(ul);

	// back to active card view
	var button = document.createElement('button');
	var button_div = document.createElement('div');
	button_div.classList.add('button');
	button.innerHTML = 'Terug naar actieve kaart';
	button.onclick = current_card_view;
	container.appendChild(button);
}

function leader_view() {
	// get container element & clear it
	container = document.getElementById('main');
	container.innerHTML = '';

	// create current card element
	card_display = document.createElement('div');
	card_display.id = 'card_display';
	card_active = document.createElement('p');
	card_active.id = 'current_card';
	card_active.innerHTML = game_info['current_card'];
	card_display.appendChild(card_active);

	// create the player list
	// let's just forget sorting right now
	var ul = document.createElement('ul');
	ul.id = 'player_list';
	game_info['players'].forEach(function(player){
		if (player['name'] != 'Afval stapel') {
			var li = document.createElement('li');
			li.id = player['player_id'];
			var button = document.createElement('button');
			button.innerHTML = player['name']+' ('+player['stack'].length+')';
			li.appendChild(button);
			ul.appendChild(li);
		}
	});

	// card left counter
	var cards_left_counter = document.createElement('p');
	cards_left_counter.innerHTML = 'nog '+game_info['card_stack'].length+' kaarten over.';

	// player card list
	var player_cards_div = document.createElement('div');
	player_cards_div.id = "card_stack";
	player_cards_div.innerHTML = 'Click op de naam van een speler om hier hun kaarten te zien.';

	// buttons
	var end_game_button = document.createElement('button');
	end_game_button.innerHTML = 'Spel beëindigen';
	end_game_button.onclick = end_game;

	var undo_button = document.createElement('button');
	undo_button.innerHTML = 'Ongedaan maken';
	undo_button.onclick = undo;

	var graveyard_button = document.createElement('button');
	graveyard_button.innerHTML = 'Afval stapel';
	graveyard_button.id = game_info['players'].length-1;

	// adding all elements into the container
	container.appendChild(card_display);
	container.appendChild(ul);
	container.appendChild(cards_left_counter);
	container.appendChild(player_cards_div);
	container.appendChild(end_game_button);
	container.appendChild(undo_button);
	container.appendChild(graveyard_button);
	leader_card(game_info['players'].length);
	if (selected_player !== null) {
		leader_view_cards(selected_player);
	}
}

//////////
// MAIN //
//////////
var view = 'current';
var first_refresh = new Boolean(true);
var notification = new Audio('sound/notification.mp3');

if (own_id == 11) {
	view = 'leader';
	var selected_player = null;
}

start_update();

window.setInterval(function(){
	start_update();

	// if game has ended
	if (game_info['card_stack'] == 0) {
		document.location.href = './end/';
	}

	update_view();
}, 3000);
