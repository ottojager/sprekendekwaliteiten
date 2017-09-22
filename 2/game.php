<?php
session_start();
if (!isset($_SESSION['game_id'])) {
	header('Location: ./');
}
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("./games/$game.json"), true);
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Speelvorm 2</title>
		<script src="api/js/std.js"></script>
        <script>
			var amount_players = <?php echo count($json['players']);?>;
			window.setInterval(function(){
				start_update();
				document.getElementById("current_card").innerHTML = game_info['current_card'];
                // card stack
				var list = document.getElementById('card_stack');
				list.innerHTML = '';
				game_info['players'][<?php echo $_SESSION['player_id']; ?>]["stack"].forEach(function(item, index){
					var child = document.createElement('li');
					child.innerHTML = item;
					list.appendChild(child);
				});

				//changing player list order
				//check if the displayer player list doesn't match the new one
				if (game_info['current_player'] != document.getElementById("player_list").firstElementChild.id) {
					//fill player list inits
					var player_list = document.getElementById('player_list');
					player_list.innerHTML = '';
					console.log('cleared player list');
					//fill list starting with the current till last player
					for (var i = game_info['current_player']; i < amount_players; i += 1) {
						console.log('adding player to list:' + i);
						var li = document.createElement('li');
						li.innerHTML = game_info['players'][i]['name'];
						li.id = i;
						player_list.appendChild(li);
					};
					//check if player = 0 becuase this code is then useless
					if (game_info['current_player'] > 0) {
						//fill list starting with first player to the player before the current one
						for (var i = 0; i < game_info['current_player']; i++) {
							console.log('adding player to list 2:' + i);
							var li = document.createElement('li');
							li.innerHTML = game_info['players'][i]['name'];
							li.id = i;
							player_list.appendChild(li);
						};
					};

					addListeners(amount_players);
				};
			}, 5000);
		</script>
        <link rel="stylesheet" href="css/game.css" type="text/css">
        <link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
        <h1>Kwaliteitenspel</h1>
		<p id="current_card"></p>
        <ul id="player_list">
            <?php
            foreach ($json['players'] as $key => $value) {
                echo '<li id="'.$value['player_id'].'">'.$value['name'].'</li>';
            }
            ?>
        </ul>
        <ul id="card_stack">
        </ul>
	</body>
</html>
<script>addListeners(amount_players);
//alert(document.getElementById("player_list").firstElementChild.text);
</script>
