<?php
session_start();
if (isset($_SESSION['game_id'])) {
	$game = $_SESSION['game_id'];
	$json = file_get_contents("../games/$game.json");
	echo $json;
} else {
	header('HTTP/1.1 403 Forbidden');
}
?>
