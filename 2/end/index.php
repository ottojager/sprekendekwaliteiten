<?php
session_start();
// main file for the end of the game

if (!isset($_SESSION['player_id']) && !isset($_SESSION['game_id'])) {
	header('Location: ../');
}
$game = $_SESSION['game_id'];
$json = json_decode(@file_get_contents("../games/$game.json"), true);
if ($json['game_started'] == false) {
	header('Location: ../');
}

if ($json['card_stack'] != array()) {
	header('Location: ../game.php');
}
if (!(bool)$json) { // if $json actually has content
	@unlink("../games/$game.json"); // delete the empty file if one were to exist
	header('Location: ../delete.php'); // send the user to delete.php to have their session cleared
}
if ($_SESSION['player_id'] == 11) {
	include('leader.php');
} else {
	$player = $json['players'][ $_GET['p'] ];
	include('players.php');
}
?>
