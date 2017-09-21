<?php
session_start();
if (!isset($_SESSION['game_id'])) {
	header('Location: ./');
}
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Speelvorm 2</title>
		<script src="api/js/std.js"></script>
        <script>
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
			}, 2000);
		</script>
        <link rel="stylesheet" href="css/game.css" type="text/css">
        <link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
        <h1>Kwaliteitenspel</h1>
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
<script>addListeners(<?php echo count($json['players']);?>)</script>
