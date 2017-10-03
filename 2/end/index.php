<?php
session_start();
// main file for the end of the game

if (!isset($_SESSION['player_id']) && !isset($_SESSION['game_id'])) {
	header('Location: ../');
}
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);

if ($_SESSION['player_id'] == 11) {
	include('leader.php');
} else {
	$player = $json['players'][ $_SESSION['player_id'] ];
	include('players.php');
}
?>
