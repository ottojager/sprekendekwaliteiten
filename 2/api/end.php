<?php
// called to end an already running game
session_start();
if ($_SESSION['player_id'] == 11 && isset($_SESSION['game_id'])) {
	$game = $_SESSION['game_id'];
	$json = json_decode(file_get_contents("../games/$game.json"), true);
	$json['card_stack'] = array();
	file_put_contents("../games/$game.json", json_encode($json));
} else {
	header('HTTP/1.1 403 Forbidden');
}
?>
