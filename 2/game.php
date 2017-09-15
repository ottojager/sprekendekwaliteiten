<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Speelvorm 2</title>
		<script src="api/js/std.js"></script>
        <script>
			start_update()
			addListeners()
			window.setInterval(function(){
				start_update();
                // card stack
                game_info['players'][<?php echo $_SESSION['player_id']; ?>]["stack"].forEach(function(item, index){
					var child = document.createElement('li');
					child.innerHTML = item;
					list.appendChild(child);
				});
				document.getElementById("current_card").innerHTML = game_info['current_card'];
				//document.getElementById("player_list").innerHTML = game_info[""];
			}, 5000);
		</script>
	</head>
	<body>
		<p id="current_card"></p>
        <ul id="player_list">
            <?php
            $game = $_SESSION['game_id'];
            $json = json_decode(file_get_contents("./games/$game.json"), true);
            foreach ($json['players'] as $key => $value) {
                echo '<li id="'.$value['player_id'].'">'.$value['name'].'</li>';
            }
            ?>
        </ul>
        <ul id="card_stack">
        </ul>
	</body>
</html>
