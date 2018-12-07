//Because I can't think of a less complicated way to grab the clicked card's name in JS right now
var current_swapped_card = null;
var element_to_swap = null;
var old_card_text = null;
var last_traded_id = -1;



function give_card(clicked_id) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			window.location = './';  // send whoever called this function back to the game's main page
		}
	}
	xhttp.open("GET", "./api/game_logic.php?player_id=" + clicked_id, true);
	xhttp.send();
	start_update();
}

function swap_card(element, clickedId, clickedName) {
	var card = document.getElementById('current_swap_card');
	//just leave the function if we're trying to trade the current card for itself
	if (last_traded_id == clickedId) return;

	var card = document.getElementById('current_swap_card');
	var confirmation = confirm("Wil je " + clickedName + " ruilen voor " + card.innerText + '?');

	//check if player actually wants to trade 2 cards
	if (confirmation) {
		//Undo the previous swap, if there is one
		undo_visual_swap();
		//store the swapped card element in a variable so we can access it from other functions later
		element_to_swap = element;
		last_traded_id = clickedId;
		//pass the current card (the red one on the left) to the visual swap method
		do_visual_swap(card);
	}
	else {
		document.getElementById("back_without_trade_btn").focus();
	}

}

function do_visual_swap(card) {
	old_card_text = element_to_swap.innerText;
	//give the darkblue card a new name (of the current card, of course)
	element_to_swap.innerText = card.innerText;
	//hide current card, because it's now in the player's hand!
	card.style = "display:none;";
	//focus on the confirm trade button, which finalizes the trade and ends this player's turn
	document.getElementById("confirm_btn").focus();
}

function undo_visual_swap() {
	//check just to make sure we're not trying to undo something that hasn't happened
	if (old_card_text != null) {
		//give the hand card its old value back
		element_to_swap.innerText = old_card_text;
		//un-hide the current card
		document.getElementById('current_swap_card').style.removeProperty('display');
		//set these back to null
		old_card_text = null;
		element_to_swap = null;
		last_traded_id = -1;
	}
}

function confirm_swap() {
	//make sure we've actually swapped a card before we try to send the swap to server
	if (last_traded_id == -1) {
		var confirmation = confirm("Je hebt nog geen kaart omgeruild. Wil je dit alsnog doen?");
		if (!confirmation) {
			//if the player doesn't want to trade anymore, just go back to main screen
			window.location = './';
		}
		//TODO: maybe put focus (back) on cards so the player knows where to pick a card?

		//then just exit the function to prevent sending a swap to server
		return;
	}

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		//this time our decision to swap is final, so we can redirect the player back to the main game window
		window.location = './';
	}
	xhttp.open("GET", "./api/game_logic.php?player_id=" + own_id + "&card=" + last_traded_id, true);
	xhttp.send();
	start_update();
}

function start_update() {
	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
	 		//document.getElementById("main").innerHTML = this.responseText;
		 	game_info = JSON.parse(this.responseText);
		} else if (this.readyState == 4 && this.status == 204) {
			window.location.href = '../delete.php'; // redirect users to delete.php to have session cleared
		}
  	}
	xhttp.open("GET", "./api/check.php", true);
	xhttp.send();
}

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

function update_view() {
	if (last_change == game_info['last_change']) {
		return
	} else {
		last_change = game_info['last_change'];
	}
	// below function has to be implemented per page
	// if this function ends up being undefined look at the page not this code
	update_page_view();
}

//////////
// MAIN //
//////////
var last_change = 0;

if (own_id == 11) {
	view = 'leader';
	var selected_player = null;
}

start_update();

window.setInterval(function(){
	start_update();

	// if game has ended
	if (game_info['card_stack'] == 0 && own_id != 11) {
		document.location.href = '../end/';
	}
	update_view();
}, 3000);
