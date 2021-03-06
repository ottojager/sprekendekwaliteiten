<?php
session_start();
// main file for the end of the game

if (!isset($_SESSION['player_id']) || !isset($_SESSION['game_id'])) {
	header('Location: ../');
	exit();
}
$game = $_SESSION['game_id'];
$json = json_decode(@file_get_contents("../games/$game.json"), true);
if ($json['game_started'] == false) {
	header('Location: ../');
	exit();
}

if (sizeof($json['card_stack']) > 0) {
	header('Location: ../game.php');
	exit();
}
if (!(bool)$json) { // if $json actually has content
	@unlink("../games/$game.json"); // delete the empty file if one were to exist
	header('Location: ../delete.php'); // send the user to delete.php to have their session cleared
	exit();
}
if ($_SESSION['player_id'] != 11) { //removed leader include, let's just keep leader on the game page
	include('./players.php');
}
?>
