<?php
session_start();
if (isset($_SESSION['game_id'])) {
	$game = $_SESSION['game_id'];
	$json = @file_get_contents("../../games/$game.json"); // open the game's json file (hide warnings if they arise)
	if ((bool)$json) { // if $json actually has content
		echo $json;
	} else {
		@unlink("../games/$game.json"); // delete the empty file if one were to exist
		header('HTTP/1.1 204 No Content'); // send back a 204
										   // the request has been recieved but no content will be returned
	}
} else {
	header('HTTP/1.1 403 Forbidden');
}
?>
