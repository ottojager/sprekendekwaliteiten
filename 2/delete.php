<?php
session_start();
if ($_SESSION['player_id'] == 11 && isset($_SESSION['game_id'])) {
	$game = $_SESSION['game_id'];
	unlink("./games/$game.json");
}
session_unset();
header('Location: ./');
?>
