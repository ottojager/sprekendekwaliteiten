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
			xhttp.open("GET", "http://localhost/kwal-spel/2/api/end.php", true);
			xhttp.send();
		}
		</script>
		<?php } // end user only JS ?>
		<script>
			var amount_players = <?php echo count($json['players']);?>;
			var own_id = <?php echo $_SESSION['player_id'];?>;
			var first_refresh = new Boolean(true);
			var notification = new Audio('sound/notification.mp3');
			window.setInterval(function(){
				start_update();

				// if game has ended
				if (game_info['card_stack'] == 0) {
					document.location.href = './end/?p='+own_id;
				}

				document.getElementById("current_card").innerHTML = game_info['current_card'];
				document.getElementById("card_image").alt = game_info['current_card'];
				// check if displayed gotten card is less than the newest info if so update HTML

				<?php if ($_SESSION['player_id'] != 11) { // update card list for players ?>
				if (document.getElementById("card_stack").childNodes.length != game_info['players'][own_id]['stack'].length) {
					// card stack
					console.log('remaking cardstack')
					var list = document.getElementById('card_stack');
					list.innerHTML = '';
					game_info['players'][<?php echo $_SESSION['player_id']; ?>]["stack"].forEach(function(item, index){
						var child = document.createElement('li');
						child.innerHTML = item;
						list.appendChild(child);
					});
					if (first_refresh) {
						first_refresh = !first_refresh;
					} else {
						notification.play();
					}
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
						console.log('adding player to list:' + i);
						var li = document.createElement('li');
						var button =  document.createElement('button');
						button.innerHTML = game_info['players'][i]['name'] + '(' + game_info['players'][i]['stack'].length + ')';
						li.appendChild(button);
						li.id = i;
						player_list.appendChild(li);
					};
					//check if player = 0 becuase this code is then useless
					if (game_info['current_player'] > 0) {
						//fill list starting with first player to the player before the current one
						for (var i = 0; i < game_info['current_player']; i++) {
							console.log('adding player to list 2:' + i);
							var li = document.createElement('li');
							var button =  document.createElement('button');
							button.innerHTML = game_info['players'][i]['name'] + '(' + game_info['players'][i]['stack'].length + ')';
							li.appendChild(button);
							li.id = i;
							player_list.appendChild(li);
						};
					};

					addListeners(amount_players);
					<?php
					// leader only
					if ($_SESSION['player_id'] == 11) {
					?>
					leader_card(amount_players);
					<?php } ?>
					//check it is the players turn
					if (game_info['current_player'] == own_id) {
						document.getElementById("current_card").focus();
						notification.play();
						console.log('focusing current card');
					}
					//update amount of cards left
					document.getElementById("cards_left").innerHTML =  'nog ' + game_info['card_stack'].length + ' kaarten';
				};
			}, 5000);
		</script>
		<title>Spel - Feedback - Kwaliteitenspel</title>
		<link rel="stylesheet" href="css/game.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<h1>Spel - Feedback - Kwaliteitenspel</h1>
		<h2><?php
			if ($_SESSION['player_id'] == 11) {
				echo 'Spelleider';
			} else {
				echo $json['players'][ $_SESSION['player_id'] ]['name']; // look it works don't touch it
			}
		?></h2>
		<div id="card_display"><img id="card_image" src="css/kaart-liggend%20goed.png" alt=""><p tabindex="1" id="current_card"></p></div>
		<ul tabindex="2" id="player_list">
			<?php
			foreach ($json['players'] as $key => $value) {
				echo '<li id="'.$value['player_id'].'">'.'<button>'.$value['name'].' (0)</button>'.'</li>';
			}
			?>
		</ul>
		<div tabindex="3" id="cards_left">
			<?php echo 'nog '.sizeof($json['card_stack']).' kaarten';?>
		</div>

		<!-- keep these on one line or JS will see a child element that isn't there -->
		<ul tabindex="4" id="card_stack" class="card_stack"></ul>
		<?php
		if ($_SESSION['player_id'] == 11) { // if user is game leader
			// Leader only end game, undo buttons, and card list
		?>
		<button tabindex="5" onclick="end_game()">Game beindigen</button>
		<button tabindex="6" onclick="undo()"><img src="css/Knop.png" alt="Ongedaan maken"></button>
		<?php } // end leader only buttons ?>
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
