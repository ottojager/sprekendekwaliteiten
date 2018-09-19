function reply_click(clicked_id) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "./api/game_logic.php?sel=" + clicked_id, true);
	xhttp.send();
	start_update();
}

function addListeners(amount_players) {
	"use strict";
	var i;
	for (i = 0; i <  amount_players - 1; i += 1) {
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
	// var list = document.getElementById('card_stack');
	// list.innerHTML = '';
	// game_info['players'][id_player]['stack'].forEach(function(item, index){
	// 	var child = document.createElement('li');
	// 	child.innerHTML = item;
	// 	list.appendChild(child);
	// });
}

function help_window() {
	var name = game_info['players'][ game_info['current_player'] ]['name'];
	var content = name + ' is aan de beurt. ' + name + ' selecteert in de lijst spelers een naam aan wie hij/zij de kwaliteit wil geven';
	alert(content);
}

function update_view() {
	if (view == 'current'){
		current_card_view();
	} else {
		recieved_cards_view();
	}
}

function current_card_view() {
	view = 'current';

	// get container element & clear it
	var container = document.getElementById('container');
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

	container.appendChild(card_display);
	container.appendChild(ul);
	addListeners(game_info['players'].length);
}

function received_cards_view() {
	view = 'received';
	// get container element & clear it
	container = document.getElementById('container');
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
}
var view = 'current';

start_update();
update_view();

window.setInterval(function(){
	start_update();
}, 3000);
