function send_mail() {
	var email = document.getElementById('email').value; //TODO: check for empty email
														// Het verplichte veld \'Email\' is niet ingevuld.
	var pattern =
/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
// checks for valid email adderess
	var match = pattern.test(email);
	var p = document.getElementById('error');
	if (!match) {
		alert('Het veld \'Email\' is niet goed ingevuld.\nZorg dat het een correct formaat heeft bijvoorbeeld \'naam@domein.nl\'.');
		exit();
	} else {
		console.log('check passed')

		var email = encodeURIComponent(email);

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 400) {
				alert('Het ingevulde email adderess klopt niet');
			} else if (this.readyState == 4 && this.status == 200) {
				alert('de mail is verstuurd');
				var email = document.getElementById('email').value = '';
			}
		};
		xhttp.open('POST', './mail.php', true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send('email='+email); // put any post values in here
	}
}
