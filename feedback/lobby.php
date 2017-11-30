<?php
session_start();

if (!isset($_SESSION['game_id'])) {
	header('location: ./');
}

// load game's json file
$game = $_SESSION['game_id'];
$json = json_decode(@file_get_contents("./games/$game.json"), true);
if (!(bool)$json) { // if $json actually has content
	@unlink("../games/$game.json"); // delete the empty file if one were to exist
	header('Location: ./delete.php'); // send the user to delete.php to have their session cleared
}
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Spelvoorbereiding - Feedback - Kwaliteitenspel</title>
		<script src="api/js/std.js"></script>

		<?php
		// java script only needed for the game leader
		if ($_SESSION['player_id'] == 11) {
		?>
			<script>
				function start_game() {
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							window.location.href = 'game.php';
						}
					};
					xhttp.open("GET", "./api/start.php", true);
					xhttp.send();
				}
				</script>
		<?php } // end of leader only javascript ?>

		<script>
			var id = <?php echo $_SESSION['player_id']; ?>; // the ID of the current user

			var s = 3000; // how often to refresh in ms
			window.setInterval(function(){ // run this code every [s] seconds
				start_update(); // get the new game_info
				if (game_info["game_started"] == true) {
					window.location.href = 'game.php'; // redirect users if the game has been started
				}

				// regenerate the player list
				var list = document.getElementById("player_list");
				list.innerHTML = ''; // empty the list
				game_info["players"].forEach(function(item, index){
					var child = document.createElement('li');
					child.innerHTML = item['name'];

					<?php if ($_SESSION['player_id'] == 11) { ?>
						// kick button only visible to the game leader
						var button = document.createElement('button');
						button.onclick = function() { // send a request to the server to kick the player with ID [index]
							var xhttp = new XMLHttpRequest();
							xhttp.open("GET", "./api/kick.php?p="+index, false);
							xhttp.send();
						}
						button.innerHTML = '<img src="css/trash-icon.png" alt="verwijder speler" height="25" width="25">';
						child.appendChild(button);
					<?php } ?>

					list.appendChild(child);
				});
			}, s);
		</script>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/lobby_stylesheet.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<div id="topbar"></div>
		<div id="sidetopbar">
			<div id="borderimage"></div>
			<div id="player__name"></div>
		</div>
		<div id="main">
		<h1>Spelvoorbereiding - Feedback - Kwaliteitenspel</h1>
			<?php if ($_SESSION['player_id'] == 11) { // game leader only ?>
			<h2 id="game_id">Spelvoorbereiding</h2>
			<p>Geef de spelers deze code:<?php echo $json['game_id']; ?><br />
			<br />
			De volgende spelers doen mee:</p>

			<?php } else { // player only ?>
			<p>De volgende spelers doen mee:</p>
			<?php } ?>

			<ul id="player_list">
			<?php
			foreach ($json['players'] as $key => $value) {
				if ($_SESSION['player_id'] == 11) {
					echo '<li>'.$value['name'].'<button onclick="alert(\''.$key.'\')"><img src="css/trash-icon.png" alt="verwijderen" height="25" width="25"></button></li>';
				} else {
					echo '<li>'.$value['name'].'</li>';
				}
			}
			?>
			</ul>
		<?php
		if ($_SESSION['player_id'] == 11) {
			?><button onclick="start_game()">Start het spel</button><?php
		}
		?>
		</div>
	</body>
</html>
