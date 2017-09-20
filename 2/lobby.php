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
				document.getElementById("game_id").innerHTML = game_info['game_id'];
				document.getElementById("leader").innerHTML = 'Leader: ' + game_info['leader_name'];
				//document.getElementById("player_list").innerHTML = game_info[""];
			}, 3000);
		</script>
        <link rel="stylesheet" href="css/lobby_stylesheet.css" type="text/css">
        <link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<div id="main">
			<?php
			$game = $_SESSION['game_id'];
			$json = json_decode(file_get_contents("./games/$game.json"), true);
			echo '<h3 id="game_id">'.$json['game_id'].'</h3>';
			echo '<p id="leader">Leader: '.$json['leader_name'].'</p>';
			echo '<ol id="player_list">';
			foreach ($json['players'] as $key => $value) {
				echo '<li>'.$value['name'].'</li>';
			}
			echo '</ol>';
			?>
		</div>
		<?php
		if ($_SESSION['player_id'] == 9) {
			?><button onclick="start_game()">Game beginnen</button><?php
		}
		?>
	</body>
</html>
