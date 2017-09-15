<?php
session_start();
$game = $_SESSION['game_id'];

$json = json_decode(file_get_contents("../games/$game.json"), true);
if ($_SESSION['player_id'] == $json['current_player']) {
	$json['current_player'] = $json['current_player'] + 1;
	if ($_GET['sel'] != $_SESSION['player_id']) {
		$json['players'][$_GET['sel']]['stack'][] = $json['current_card'];
		$json['current_card'] = array_shift($json['card_stack']);
	}
}
file_put_contents("../games/$game.json", json_encode($json));
// fopen("test.txt", "w", $_SESSION['game_id');
// fclose("test.txt");
?>
