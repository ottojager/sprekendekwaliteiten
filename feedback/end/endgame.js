function send_mail() {
	var email = document.getElementById('email').value;
	if (email == '') {
		alert('Het verplichte veld \'Email\' is niet ingevuld.');
		return
	}
	var pattern =
/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
// checks for valid email adderess
	var match = pattern.test(email);
	var p = document.getElementById('error');
	if (!match) {
		alert('Het veld \'Email\' is niet goed ingevuld.\nZorg dat het een correct formaat heeft bijvoorbeeld \'naam@domein.nl\'.');
		exit();
	} else {
		console.log('check passed');

		var email = encodeURIComponent(email);

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 400) {
				alert('Het ingevulde email adderess klopt niet');
			} else if (this.readyState == 4 && this.status == 200) {
				// alert('De mail is verstuurd');
				window.location = './success.php'
				var email = document.getElementById('email').value = '';
			}
		};
		xhttp.open('POST', './mail.php', true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send('email='+email); // put any post values in here
	}
}

// function render_card_list(index, pid, cards) {
// 	// clear out old list
// 	var container = document.getElementById('card-list-container-'+pid);
// 	container.innerHTML = '';
//
// 	var list = document.createElement('ul');
// 	for (i = index; i != index+cards && i != card_list[pid].length; i++) {
// 		console.log(card_list[pid][i]);
// 		var item = document.createElement('li');
// 		item.innerHTML = card_list[pid][i];
// 		list.appendChild(item);
// 	}
// 	container.appendChild(list);
//
// 	// back & forwards buttons
// 	if (index != 0) {
// 		var back_button = document.createElement('button');
// 		back_button.innerHTML = 'Vorge';
// 		back_button.onclick = function() {
// 			console.log(index-cards);
// 			render_card_list(index-cards, pid, cards);
// 		}
// 		container.appendChild(back_button);
// 	}
//
// 	if (index+cards < card_list[pid].length) {
// 		var continue_button = document.createElement('button');
// 		continue_button.innerHTML = 'Volgende';
// 		continue_button.onclick = function() {
// 			console.log(index+cards);
// 			render_card_list(index+cards, pid, cards);
// 		}
// 		container.appendChild(continue_button);
// 	}
// }

function leader_initial_rendering_calls(player_count) {
	for (n = 0; n <= player_count; n++) {
		render_card_list(0, n, 6);
	}
}
