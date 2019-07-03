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

		var email = encodeURIComponent(email);

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 400) {
				alert('Het ingevulde email adres klopt niet');
			} else if (this.readyState == 4 && this.status == 200) {
				window.location = './success.php'
				document.getElementById('email').value = '';
			}
		};
		xhttp.open('POST', './mail.php', true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send('email='+email); // put any post values in here
	}
}

function leader_initial_rendering_calls(player_count) {
	for (n = 0; n <= player_count; n++) {
		render_card_list(0, n, 6);
	}
}

function startGameMode4() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = '../../kernkwadranten/getstarted.php';
        }
    };
    xhttp.open("POST", "../../kernkwadranten/api/new.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify(cards));
}
