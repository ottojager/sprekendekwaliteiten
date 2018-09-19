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
		<script src="api/js/std.js"></script>
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
			var first_refresh = new Boolean(true);
			var notification = new Audio('sound/notification.mp3');
			window.setInterval(function(){
				start_update();

				// if game has ended
				if (game_info['card_stack'] == 0) {
					document.location.href = './end/';
				}
				update_view();
			}, 5000);
		</script>
		<meta charset="utf-8">
		<title>Actief - Feedback - Kwaliteitenspel</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="./css/game.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<div id="topbar"></div>
		<div id="sidetopbar">
			<div id="borderimage"></div>
			<div id="player__name">
				<span><?php
				if ($_SESSION['player_id'] == 11) {
					echo 'Spelleider';
				} else {
					echo $json['players'][ $_SESSION['player_id'] ]['name']; // look it works don't touch it
				}
				?></span>
				<button id="help" onclick="help_window()">Help!</button>
			</div>
		</div>
		<div id="container">
			<h1 class="col-xs-12 col-sm-12 col-md-12">Actief - Feedback - Kwaliteitenspel</h1>

			<div id="blind_current_player" tabindex="1">
				<?php echo $json['players'][$json['current_player']]['name']." is aan de beurt." ?>
			</div>

			<h2 id="card_active" class="col-xs-2 col-sm-2 col-md-2">Actieve kaart:</h2>
			<div id="card_display" class="col-xs-10 col-sm-5 col-md-5"><p id="current_card"><?php echo $json['current_card']; ?></p></div>
			<div class="col-xs-12 col-sm-4 col-md-3">
				<h2>Spelers:</h2>
				<ul id="player_list" >

				<?php
				foreach ($json['players'] as $key => $value) {
					if ($value['name'] != 'Afval stapel') {
						echo '<li id="'.$value['player_id'].'">'.'<button>'.$value['name'].' ('.count($value['stack']).')</button>'.'</li>';
					}
				}
				?>
				</ul>
			</div>
			<div id="cards_left" class="col-xs-10 col-md-2">
				<?php echo 'nog '.sizeof($json['card_stack']).' kaarten';?>
			</div>
			<div style="clear: both;"></div>

			<div class="row" id="knoppen">
				<div class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0">
					<a class="skiplink" href="#blind_current_player">Naar huidige kaart</a>
				</div>
					<?php
					if ($_SESSION['player_id'] != 11) {
						echo '<div class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button onclick="reply_click('. (count($json['players'])-1) .')">Kaart weggooien</button></div>';
					}
					else { // if user is game leader
					       // Leader only end game, undo buttons, and card list
					?>
					<button onclick="end_game()">Spel beëindigen</button>
					<button onclick="undo()">Ongedaan maken</button>
				<?php } // end leader only buttons ?>
			</div>
		</div>
		<?php include('../footer.php') ?>
	</body>
</html>
<?php
// adding listeners
if ($_SESSION['player_id'] == 11) {
?>
<script>
leader_card(amount_players);
</script>
<?php } else { ?>
<script>
// addListeners(amount_players);
//alert(document.getElementById("player_list").firstElementChild.text);
</script>
<?php } ?>
