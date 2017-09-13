<?php
session_start();

if (!isset($_SESSION['game_id'])) {
	header('location: ./');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Speelvorm 2</title>
		<script src="api/js/std.js"></script>

		<?php
		// java script only needed for the game leader
		if ($_SESSION['player_id'] == 9) {
		?>
		<script>
			function start_game() {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						window.location.href = 'game.php';
					}
				};
				xhttp.open("GET", "http://localhost/kwal-spel/2/api/start.php", true);
				xhttp.send();
			}
		</script>
		<?php } // end of leader only javascript ?>

		<script>
			window.setInterval(function(){
				start_update();
				if (game_info["game_started"] == true) {
					window.location.href = 'game.php';
				}
				//document.getElementById("leader").innerHTML = game_info["leader_name"];
				var list = document.getElementById("player_list");
				list.innerHTML = '';
				game_info["players"].forEach(function(item, index){
					var child = document.createElement('li');
					child.innerHTML = item['name'];
					list.appendChild(child);
				});
				//document.getElementById("player_list").innerHTML = game_info[""];
			}, 3000);
		</script>
	</head>
	<body>
		<div id="main">
			<p id="leader"></p>
			<ol id="player_list">
			</ol>
		</div>
		<?php
		if ($_SESSION['player_id'] == 9) {
			?><button onclick="start_game()">Game beginnen</button><?php
		}
		?>
	</body>
</html>
