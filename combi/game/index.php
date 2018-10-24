<?php
session_start();


if (!isset($_SESSION['game_id'])) {
	header('Location: ../');
}
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);
if ($json['game_started'] == false) {
	header('location: ../lobby.php');
}

// reset player_id values so they match again
// also check if they player has been kicked or not and redirect those back to the home screen
if ($_SESSION['player_id'] != 11) {
	$kicked = true; // used to check if the player may have been kicked
	foreach ($json['players'] as $key => $value) {
		if ($value['name'] == $_SESSION['player_name']) {
			$_SESSION['player_id'] = $value['player_id'];
			$kicked = false;
		}
	}
	if ($kicked) {
		header('Location: ../delete.php'); // delete the player we don't care
	}
}

// create some variables to add header values
$spelvorm = 'Combi';
$name = $_SESSION['player_name'];

// TODO: add code to figure out where each player needs to actually be
if ($_SESSION['player_id'] == $json['current_player']) {
	include('game.php');
} else {
	include('hand.php');
}
?>
