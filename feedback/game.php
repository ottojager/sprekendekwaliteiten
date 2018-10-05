<?php
session_start();


if (!isset($_SESSION['game_id'])) {
	header('Location: ./');
}
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("./games/$game.json"), true);
if ($json['game_started'] == false) {
	header('location: ./lobby.php');
}

// reset player_id values so they match again
// also check if they player has been kicked or not and redirect those back to the home screen
if ($_SESSION['player_id'] != 11) {
	$kicked = true; // used to check if the player may have been kicked
	foreach ($json['players'] as $key => $value) {
		if ($value['name'] == $_SESSION['player_name']) {
			$_SESSION['player_id'] = $value['player_id'];
			$kicked = false;
		}
	}
	if ($kicked) {
		header('Location: ./delete.php'); // delete the player we don't care
	}
}

?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<script src="api/js/std.js" defer></script>
		<?php
		// leader only JS
		if ($_SESSION['player_id'] == 11) { // if user is game leader
		?>
		<script>
		function end_game() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.location.href = './end/';
				}
			};
			xhttp.open("GET", "./api/end.php", true);
			xhttp.send();
		}
		</script>
		<?php } // end leader only JS ?>
		<script>
			var amount_players = <?php echo count($json['players']);?>;
			var own_id = <?php echo $_SESSION['player_id'];?>;
		</script>
		<meta charset="utf-8">
		<title>Actief - Feedback - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="./css/game.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<ul class="skip-link">
			<li><a href="#main">Skip naar main content</a></li>
		</ul>
		<?php
		// create some variables to add header values
		$spelvorm = 'Feedback';
		$name = $_SESSION['player_name'];

		include('../header.php');
		?>
		<?php if ($_SESSION['player_id'] != 11) {
		/////////////
		// players //
		/////////////
		?>
		<div id="container" class="player-container">
			<div id="card_display">
				<p id="current_card"><?php echo $json['current_card']; ?></p>
			</div>

			<ul id="player_list">
				<?php
				foreach ($json['players'] as $key => $value) {
					if ($value['name'] != 'Afval stapel') {
						echo '<li id="'.$value['player_id'].'"><button>'.$value['name'].' ('.count($value['stack']).')</button></li>';
					}
				}
				?>
			</ul>
			<button id="<?php echo count($json['players'])-1 ?>" onclick="reply_click(<?php echo count($json['players'])-1 ?>)">Afval stapel</button>

			<button onclick="received_cards_view()">Ontvangen kaarten</button>
		<?php } else {
		/////////////////
		// game leader //
		/////////////////
		?>
		<div id="container" class="leader-container">
			<div id="card_display">
				<p id="current_card"><?php echo $json['current_card']; ?></p>
			</div>

			<ul id="player_list">
				<?php
				foreach ($json['players'] as $key => $value) {
					if ($value['name'] != 'Afval stapel') {
						echo '<li id="'.$value['player_id'].'"><button>'.$value['name'].' ('.count($value['stack']).')</button></li>';
					}
				}
				?>
			</ul>
			<p>nog <?php echo count($json['card_stack']); ?> kaarten over.</p>
			<div id="card_stack">
				<p>Click op de naam van een speler om hier hun kaarten te zien.</p>
			</div>
			<button onclick="end_game()">Spel beëindigen</button>
	        <button onclick="undo()">Ongedaan maken</button>
			<button id="<?php echo count($json['players'])-1 ?>" onclick="leader_view_cards(<?php echo count($json['players'])-1 ?>)">Afval stapel</button>
		<?php } ?>
		</div>
		<?php include('../footer.php') ?>
	</body>
</html>
<?php
// adding listeners
if ($_SESSION['player_id'] == 11) {
?>
<script>
// leader_card(amount_players);
</script>
<?php } ?>
