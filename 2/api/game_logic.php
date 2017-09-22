<?php
//init stuff
session_start();
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);
//check if it is the players turn
if ($_SESSION['player_id'] == $json['current_player']) {
	//check if player didn't select themself
	if ($_GET['sel'] != $_SESSION['player_id']) {
		//add card to chosen players cards and draw new card
		$json['players'][$_GET['sel']]['stack'][] = $json['current_card'];
		//check if there are any cards left if so end the game
		if (empty($json['card_stack'])) {
			//save game and go scorboard/end thingy
			file_put_contents("../games/$game.json", json_encode($json));
			window.location.href = 'end.php';
		}
		$json['current_card'] = array_shift($json['card_stack']);
		//give turn to next player
		if ($json['current_player'] == count($json['players']) - 1) {
			$json['current_player'] = 0;
		} else {
			$json['current_player'] = $json['current_player'] + 1;
		}
	}
	//save changes
	file_put_contents("../games/$game.json", json_encode($json));
}
?>
