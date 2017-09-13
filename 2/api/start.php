<?php
// file called to start the game
session_start();
if ($_SESSION['player_id'] == 9 && isset($_SESSION['game_id'])) {
	//TODO: add check for minimum amount of players
	$game = $_SESSION['game_id'];
	$json = (array)json_decode(file_get_contents("../games/$game.json"));
	$json['game_started'] = true;
	$db = mysqli_connect('localhost', 'root');
	mysqli_select_db($db, "kwaliteitenspel");
	$sql = "SELECT * FROM cards";
	$result = mysqli_query($db, $sql);
	$card_stack = array();
	while ($card = mysqli_fetch_assoc($result)) {
	    $card_stack[] = $card['name'];
	}
	shuffle($card_stack);
	$json['card_stack'] = $card_stack;
	file_put_contents("../games/$game.json", json_encode($json));
} else {
	header('HTTP/1.1 403 Forbidden');
}
?>
