var lastClickedLeaderId = -1;

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
	if (lastClickedLeaderId != id_player) {
		playerId = id_player.toString();
		selected_player = id_player;
		var div = document.getElementById('card_stack');
		div.innerHTML = '';

		var name = document.createElement('h3');
		if (game_info['players'][id_player]['name'] != 'Afval stapel') {
			name.innerHTML = game_info['players'][id_player]['name'];
		} else {
			name.innerHTML = 'Aflegstapel';
		}
		var list = document.createElement('ul');
		game_info['players'][id_player]['stack'].forEach(function(item, index){
			var child = document.createElement('li');
			child.innerHTML = item;
			list.appendChild(child);
		});

		div.appendChild(name);
		div.appendChild(list);

		lastClickedLeaderId = id_player;
	}
	else {
		document.getElementById('card_stack').innerHTML = '';
		lastClickedLeaderId = -1;
	}
}

function update_view() {
	if (last_change == game_info['last_change']) {
		return
	} else {
		last_change = game_info['last_change'];
	}

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

	// the text at the top of the page with the current user
	var h2 = document.createElement('h2');
	h2.innerHTML = 'Wie krijgt de kaart?';
	var current_player_text = document.createElement('p');
	current_player_text.id = 'turn';
	current_player_text.innerHTML = 'Speler '+game_info['players'][game_info['current_player']]['name']+' is aan de beurt';

	// create current card element
	var current_card_informational_text = document.createElement('h3');
	current_card_informational_text.innerHTML = 'Dit is de huidige kaart';
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
	graveyard.innerHTML = 'Wegleggen';
	graveyard.id = game_info['players'].length-1;
	graveyard_div.appendChild(graveyard);

	// recieved cards view button
	var button = document.createElement('button');
	var button_div = document.createElement('div');
	button_div.classList.add('button');
	button.innerHTML = 'Ontvangen kaarten';
	button.onclick = received_cards_view;
	button_div.appendChild(button);
	var buttons_div = document.createElement('div');
	buttons_div.classList.add('player-menu');
	buttons_div.appendChild(graveyard_div);
	buttons_div.appendChild(button_div);

	// APPEND THE CHILDREN
	container.appendChild(h2);
	container.appendChild(current_player_text);
	container.appendChild(current_card_informational_text);
	container.appendChild(card_display);
	container.appendChild(ul);
	container.appendChild(buttons_div);
	addListeners(game_info['players'].length);
}

function received_cards_view() {
	view = 'received';
	// get container element & clear it
	container = document.getElementById('main');
	container.innerHTML = '';

	// header
	header = document.createElement('h2');
	header.innerHTML = 'Dit zijn jouw ontvangen kaarten';
	container.appendChild(header);

	// the text at the top of the page with the current user or some BS
	var current_player_text = document.createElement('p');
	current_player_text.id = 'turn';
	current_player_text.innerHTML = 'Speler '+game_info['players'][game_info['current_player']]['name']+' is aan de beurt';
	container.appendChild(current_player_text);

	// create card list
	var ul = document.createElement('ul')
	game_info['players'][own_id]['stack'].forEach(function(card){
    	var li = document.createElement('li');
    	var p = document.createElement('p');
    	p.innerHTML = card;
    	li.appendChild(p);
    	ul.appendChild(li);
	});

	var ul = document.createElement('ul');
	var div = document.createElement('div');
	div.classList.add('kaart-rij');
	for (i = 0; i != game_info['players'][own_id]['stack'].length; i++) {
		if (i % 4 == 0 && i != 0) {
			ul.appendChild(div);
			var div = document.createElement('div');
			div.classList.add('kaart-rij');
		}
		var li = document.createElement('li');
		li.classList.add('kaart', 'eind-kaart');

		var button = document.createElement('button');
		button.innerHTML = game_info['players'][own_id]['stack'][i];
		li.appendChild(button);
		div.appendChild(li);
	}
	ul.appendChild(div);
	container.appendChild(ul);

	// back to active card view
	var button = document.createElement('button');
	var button_div = document.createElement('div');
	var button_div_div = document.createElement('div');
	button_div.classList.add('button');
	button_div_div.classList.add('bottom-menu');
	button.innerHTML = 'Terug naar actieve kaart';
	button.onclick = current_card_view;
	button_div.appendChild(button);
	button_div_div.appendChild(button_div);
	container.appendChild(button_div_div);
}

function leader_view() {
	// get container element & clear it
	container = document.getElementById('main');
	container.innerHTML = '';

	// the H2 at the top of the page
	var h2 = document.createElement('h2');
	h2.innerHTML = 'Wie krijgt de kaart?';

	// the text at the top of the page with the current user or some BS
	var current_player_text = document.createElement('p');
	current_player_text.id = 'turn';
	current_player_text.innerHTML = 'Speler '+game_info['players'][game_info['current_player']]['name']+' is aan de beurt';

	// create current card element
	var current_card_informational_text = document.createElement('h3');
	current_card_informational_text.innerHTML = 'Dit is de huidige kaart';
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

	// card left counter
	var cards_left_counter = document.createElement('p');
	cards_left_counter.innerHTML = 'nog '+game_info['card_stack'].length+' kaarten over.';
	cards_left_counter.id = "amount";

	// player card list
	var player_cards = document.createElement('p');
	var player_cards_div = document.createElement('div');
	player_cards_div.id = "card_stack";
	player_cards.innerHTML = 'Click op de naam van een speler om hier hun kaarten te zien.';
	player_cards_div.appendChild(player_cards);

	/////////////
	// BUTTONS //
	/////////////
	//end game button
	var end_game_button = document.createElement('button');
	var end_game_button_div = document.createElement('div');
	end_game_button_div.classList.add('button');
	end_game_button.innerHTML = 'Spel beëindigen';
	end_game_button.onclick = end_game;
	end_game_button_div.appendChild(end_game_button);

	// undo button
	var undo_button = document.createElement('button');
	var undo_button_div = document.createElement('div');
	undo_button_div.classList.add('button');
	undo_button.innerHTML = 'Ongedaan maken';
	undo_button.onclick = undo;
	undo_button_div.appendChild(undo_button);

	// graveyard_button
	var graveyard_button = document.createElement('button');
	var graveyard_button_div = document.createElement('div');
	graveyard_button_div.classList.add('button');
	graveyard_button.innerHTML = 'Aflegstapel';
	graveyard_button.id = game_info['players'].length-1;
	graveyard_button_div.appendChild(graveyard_button);

	// A P P E N D   C H I L D
	var buttons_div = document.createElement('div');
	buttons_div.appendChild(end_game_button_div);
	buttons_div.appendChild(undo_button_div);
	buttons_div.appendChild(graveyard_button_div);
	buttons_div.classList.add('player-menu');

	// adding all elements into the container
	container.appendChild(h2);
	container.appendChild(current_player_text);
	container.appendChild(current_card_informational_text);
	container.appendChild(card_display);
	container.appendChild(ul);
	container.appendChild(cards_left_counter);
	container.appendChild(player_cards_div);
	container.appendChild(buttons_div);
	leader_card(game_info['players'].length);
	if (selected_player !== null) {
		leader_view_cards(selected_player);
	}
}

//////////
// MAIN //
//////////
var view = 'current';

var last_change = 0;

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
