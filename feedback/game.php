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

				// update amount of cards left
				document.getElementById("cards_left").innerHTML = 'nog ' + game_info['card_stack'].length + ' kaarten';

				// upate current card
				document.getElementById("current_card").innerHTML = game_info['current_card'];
				document.getElementById("card_display").alt = game_info['current_card'];

				// update blind turn notifier thing
				document.getElementById("blind_current_player").innerHTML = game_info['players'][ game_info['current_player'] ]['name'] + ' is aan de beurt.';

				<?php if ($_SESSION['player_id'] != 11) { // update card list for players ?>
				if (
					(
						document.getElementById("card_stack").childNodes[0].childNodes.length != game_info['players'][own_id]['stack'].length &&
						document.getElementById("card_stack").innerHTML != 'Nog geen kaarten ontvangen.' &&
						game_info['players'][own_id]['stack'].length != 0
					) || (
						game_info['players'][own_id]['stack'].length > 0 &&
						document.getElementById("card_stack").innerHTML == 'Nog geen kaarten ontvangen.'
					)
				) { // if the user has more cards than are currently being displayed
					// or if the user a card and the card list still reads the default message

					// card stack
					console.log('remaking cardstack');
					var div = document.getElementById('card_stack');
					div.innerHTML = '';
					var list = document.createElement('ul');
					var cards = game_info['players'][<?php echo $_SESSION['player_id']; ?>]["stack"].reverse();
					game_info['players'][<?php echo $_SESSION['player_id']; ?>]["stack"].forEach(function(item, index){
						var child = document.createElement('li');
						child.innerHTML = item;
						list.appendChild(child);
					});
					div.appendChild(list);

					if (first_refresh) {
						first_refresh = !first_refresh;
					} else {
						notification.play();
					}
				} else if (
					game_info['players'][own_id]['stack'].length == 0 &&
					document.getElementById('card_stack').innerHTML != 'Nog geen kaarten ontvangen.'
				) {
					document.getElementById('card_stack').innerHTML = 'Nog geen kaarten ontvangen.';
				}
				<?php } ?>

				//changing player list order
				//check if the displayed player list doesn't match the new one ifso update HTMl
				if (game_info['current_player'] != document.getElementById("player_list").firstElementChild.id) {
					//fill player list inits
					var player_list = document.getElementById('player_list');
					player_list.innerHTML = '';
					console.log('cleared player list');
					//fill list starting with the current till last player
					for (var i = game_info['current_player']; i < amount_players; i += 1) {
						if (game_info['players'][i]['name'] != 'Afval stapel') {
							console.log('adding player to list:' + i);
							var li = document.createElement('li');
							var button =  document.createElement('button');
							button.innerHTML = game_info['players'][i]['name'] + '(' + game_info['players'][i]['stack'].length + ')';
							li.appendChild(button);
							li.id = i;
							player_list.appendChild(li);
						}
					};
					//check if player = 0 becuase this code is then useless
					if (game_info['current_player'] > 0) {
						//fill list starting with first player to the player before the current one
						for (var i = 0; i < game_info['current_player']; i++) {
							if (game_info['players'][i]['name'] != 'Afval stapel') {
								console.log('adding player to list 2:' + i);
								var li = document.createElement('li');
								var button =  document.createElement('button');
								button.innerHTML = game_info['players'][i]['name'] + '(' + game_info['players'][i]['stack'].length + ')';
								li.appendChild(button);
								li.id = i;
								player_list.appendChild(li);
							}
						}
					}

					<?php
					// leader only
					if ($_SESSION['player_id'] == 11) {
					?>
					leader_card(amount_players);
					<?php } else { // if it's not the game leader ?>
					addListeners(amount_players);
					<?php } ?>
					//check it is the players turn
					if (game_info['current_player'] == own_id) {
						document.getElementById("current_card").focus();
						notification.play();
						console.log('focusing current card');
					}
				};
			}, 5000);

			function help_window() {
				var name = game_info['players'][ game_info['current_player'] ]['name'];
				var content = name + ' is aan de beurt. ' + name + ' selecteert in de lijst spelers een naam aan wie hij/zij de kwaliteit wil geven';
				alert(content);
			}
		</script>
		<meta charset="utf-8">
		<title>Actief - Feedback - Kwaliteitenspel</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="./css/game.css" type="text/css">
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

			<div id="card_active" class="col-xs-1 col-sm-1 col-md-2 col-md-offset-1">Actieve kaart:</div>
			<div id="card_display" class="col-xs-11 col-sm-6 col-md-5"><p id="current_card"></p></div>

			<ul id="player_list" class="col-xs-11 col-sm-6 col-md-5">
				<?php
				foreach ($json['players'] as $key => $value) {
					if ($value['name'] != 'Afval stapel') {
						echo '<li id="'.$value['player_id'].'">'.'<button>'.$value['name'].' (0)</button>'.'</li>';
					}
				}
				?>
			</ul>
			<div id="cards_left">
				<?php echo 'nog '.sizeof($json['card_stack']).' kaarten';?>
			</div>

			<a class="skiplink" href="#current_card">Naar huidige kaart</a>

			<!-- keep these on one line or JS will see a child element that isn't there -->
			<?php if ($_SESSION['player_id'] != 11) { ?>
			<h2>Ontvangen kaarten</h2>
			<div id="card_stack" class="card_stack">Nog geen kaarten ontvangen.</div>
			<?php } else { ?>
			<div id="card_stack" class="card_stack">Klik op een speler om diens kaarten te zien.</div>
			<?php } ?>

			<button
			<?php
			if ($_SESSION['player_id'] == 11) {
				echo ' onclick="view_cards('. (count($json['players'])-1) .')">Afval stapel';
			} else {
				echo ' onclick="reply_click('. (count($json['players'])-1) .')">Weggooien';
			}
			?>
			</button>
			<?php
			if ($_SESSION['player_id'] == 11) { // if user is game leader
				// Leader only end game, undo buttons, and card list
			?>
			<button onclick="end_game()">Spel beëindigen</button>
			<button onclick="undo()"><img src="css/knop_goed.png" alt="Ongedaan maken"></button>
			<?php } // end leader only buttons ?>
		</div>
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
addListeners(amount_players);
//alert(document.getElementById("player_list").firstElementChild.text);
</script>
<?php } ?>
