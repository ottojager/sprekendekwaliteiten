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
<html lang="nl">
	<head>
		<title>Spelvoorbereiding - Feedback - Sprekende Kwaliteiten</title>
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
			function kick(id) { // send a request to the server to kick the player with ID [index]
				var xhttp = new XMLHttpRequest();
				xhttp.open("GET", "./api/kick.php?p="+id, false);
				xhttp.send();
			}

			var id = <?php echo $_SESSION['player_id']; ?>; // the ID of the current user

			var s = 3000; // how often to refresh in ms
			var last_change = 0;
			window.setInterval(function(){ // run this code every [s] seconds
				start_update(); // get the new game_info

				if (last_change == game_info['last_change']) {
					return
				} else {
					last_change = game_info['last_change'];
				}

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
						button.onclick = function() {
							kick(index);
						};
						button.innerHTML = '<img src="../afbeeldingen/remove-knop.png" alt="Verwijder speler" height="20" width="20">';
						child.appendChild(button);
					<?php } ?>

					list.appendChild(child);
				});
			}, s);
		</script>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="stylesheet" href="../css/spelvorm2.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		// create some variables to add header values
		$spelvorm = 'Feedback';
		$name = $_SESSION['player_name'];

		include('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
			<?php if ($_SESSION['player_id'] == 11) { // game leader only ?>
			<h2 id="game_id">Spelvoorbereiding - Feedback</h2>
			<p>Geef de spelers deze code:<?php echo $json['game_id']; ?><br />
			<br />
			De volgende spelers doen mee:</p>

			<?php } else { // player only ?>
			<h2>Spelvoorbereiding - Feedback</h2>
			<p>De volgende spelers doen mee:</p>
			<?php } ?>

			<ul id="player_list">
			<?php
			foreach ($json['players'] as $key => $value) {
				if ($_SESSION['player_id'] == 11) {
					echo '<li>'.$value['name'].'<button onclick="kick(\''.$key.'\')"><img src="../afbeeldingen/remove-knop.png" alt="Verwijder speler" height="20" width="20"></button></li>';
				} else {
					echo '<li>'.$value['name'].'</li>';
				}
			}
			?>
			</ul>
		<?php
		if ($_SESSION['player_id'] == 11) {
			?><div class="button"> <button id="start" onclick="start_game()">Start het spel</button></div><?php
		} else {
			?><p class="wacht-text">Wacht tot iedereen aanwezig is. De spelbegeleider zal het spel zometeen beginnen.</p><?php
		}
		?>
		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
