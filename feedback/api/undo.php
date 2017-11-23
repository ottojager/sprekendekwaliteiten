<?php
//init stuff
session_start();
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);
//check if it is the game leader
if ($_SESSION['player_id'] == 11) {
	if (!empty($json['turn_action'])) {
		//add current card to begin card stack
		array_unshift($json['card_stack'], $json['current_card']);
		//add last used to card to current card
		$last_player = array_pop($json['turn_action']);
		$json['current_card'] = array_pop($json['players'][$last_player]['stack']);
		//turn current player 1 back
		do {
			if ($json['current_player'] == 0) {
				$json['current_player'] = count($json['players']) - 1;
			} else {
				$json['current_player'] = $json['current_player'] - 1;
			}
		} while ($json['players'][ $json['current_player'] ]['name'] == 'Afval stapel');
		//save changes
		file_put_contents("../games/$game.json", json_encode($json));
	}
}
?>
