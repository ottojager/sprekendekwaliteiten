function start_update() {
	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
     		document.getElementById("demo").innerHTML = this.responseText;
		}
  	};
	xhttp.open("GET", "../check.php", true);
	xhttp.send();
}

window.setInterval(function(){
  start_update();
}, 5000);
