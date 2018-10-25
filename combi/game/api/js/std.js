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
	document.getElementById(id_player).addEventListener('click', function() {
		leader_view_cards_hide(this.id);
	});
}

function leader_view_cards_hide(id_player) {
	document.getElementById('card_stack').innerHTML = '';
	document.getElementById(id_player).addEventListener('click', function() {
		leader_view_cards(this.id);
	})
}

//////////
// MAIN //
//////////

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
}, 3000);
