function send_mail() {
	var email = document.getElementById('email').value;
	var pattern =
/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
// checks for valid email adderess
	var match = pattern.test(email);
	var p = document.getElementById('error');
	if (!match) {
		alert('Het ingevulde email adderess klopt niet');
		exit();
	} else {
		console.log('check passed')

		var email = encodeURIComponent(email);

		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 400) {
				alert('Het ingevulde email adderess klopt niet')
			}
		};
		xhttp.open('GET', './mail.php', true);
		xhttp.send('email='+email); // put any post values in here
									// make sure they're propperly encoded
	}
}
