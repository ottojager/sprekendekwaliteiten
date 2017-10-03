<?php
session_start();
if (isset($_SESSION['game_id'])) {
	$game = $_SESSION['game_id'];
	$json = @file_get_contents("../games/$game.json"); // open the game's json file (hide warnings if they arise)
	if ((bool)$json) { // if $json actually has content
		echo $json;
	} else {
		@unlink("../games/$game.json"); // delete the empty file if one were to exist
		header('HTTP/1.1 404 Not Found'); // send back a 404
	}
} else {
	header('HTTP/1.1 403 Forbidden');
}
?>
