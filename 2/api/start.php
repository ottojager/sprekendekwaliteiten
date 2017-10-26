<?php
// file called to start the game
session_start();
if ($_SESSION['player_id'] == 11 && isset($_SESSION['game_id'])) {
	//TODO: add check for minimum amount of players
	$game = $_SESSION['game_id'];
	$json = json_decode(file_get_contents("../games/$game.json"), true);
	$json['game_started'] = true;

	// connect to database
	$config = json_decode(file_get_contents('../database_config.json'), true); // load the db connection info
	$db = mysqli_connect($config['hostname'], $config['username'], $config['password']);

	// Create card stack
	mysqli_select_db($db, "kwalspelaccess");
	$sql = "SELECT * FROM cards";
	$result = mysqli_query($db, $sql);
	$card_stack = array();
	while ($card = mysqli_fetch_assoc($result)) {
		$card_stack[] = $card['name'];
	}
	shuffle($card_stack);
	$card_stack = array_slice($card_stack, 0, $json['max_cards']);

	// create player card stacks
	foreach($json['players'] as $key => $value) {
		$json['players'][$key]['stack'] = array();
	}
	$json['card_stack'] = $card_stack;

	//draw first card
	$json['current_card'] = array_shift($json['card_stack']);

	// make first player the active player
	$json['current_player'] = 0;

	// write back to file
	file_put_contents("../games/$game.json", json_encode($json));
} else {
	header('HTTP/1.1 403 Forbidden');
}
?>
