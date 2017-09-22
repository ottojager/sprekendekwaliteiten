function reply_click(clicked_id) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("GET", "http://localhost/kwal-spel/2/api/game_logic.php?sel=" + clicked_id, true);
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
		}
  	};
	xhttp.open("GET", "http://localhost/kwal-spel/2/api/check.php", true);
	xhttp.send();
}

start_update();

window.setInterval(function(){
	start_update();
}, 3000);

function leader_card(amount_players) {
	"use strict";
	var i;
	for (i = 0; i <  amount_players; i += 1) {
        document.getElementById(i.toString()).addEventListener('click', function() {
            var id_player = this.id;
            document.getElementById('leider').innerHTML = game_info['players'][id_player]['stack'];
        
		});
	}
}