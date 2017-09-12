<?php
// file called to start the game
if ($_SESSION['playerID'] == 9 && isset($_SESSION['game_id']))) {
	$game = $_SESSION['game'];
	$json = json_decode(file_get_contents("../games/$game.json"));
	$json['game_started'] = true;
	file_put_contents("../games/$game.json", json_encode($json));
}
?>
