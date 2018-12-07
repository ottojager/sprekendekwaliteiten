<?php
//init stuff
session_start();
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../../games/$game.json"), true);
//check if it is the players turn
if ($_SESSION['player_id'] == $json['current_player']) {
	//check if player didn't select themself
	if ($_GET['player_id'] != $_SESSION['player_id'] || isset($_GET['card'])) {
		if ($_GET['player_id'] != $_SESSION['player_id']) {
			$json['last_move_type'] = 'g'; // g stands for GIVE (sadly php does not have enums (?))
			//this is so undo can find which player was given a card
			$json['last_swapped_handindex_or_playerid'] = $_GET['player_id'];
			//add card to chosen players cards and draw new card
			$json['players'][$_GET['player_id']]['stack'][] = $json['current_card'];
		} else if (isset($_GET['card'])) {
			$index = $_GET['player_id'];
			$card = $_GET['card'];
			$json['last_move_type'] = 's'; // s stands for SWAP
			//this is so undo can find at which hand index the previous player swapped a card
			$json['last_swapped_handindex_or_playerid'] = $card;
			//this is so undo can find which card was discarded
			$json['last_played_card'] = $json['current_card'];
			$json['graveyard'][] = $json['players'][$index]['hand'][$card];
			$json['players'][$index]['hand'][$card] = $json['current_card'];
		}

		// take a new card
		$json['current_card'] = array_shift($json['card_stack']);

		// give turn to next player
		if ($json['current_player'] == count($json['players']) - 1) {
			$json['current_player'] = 0;
		} else {
			$json['current_player'] = $json['current_player'] + 1;
		}

		// update timestamp
		$json['last_change'] = time();

		//save changes
		file_put_contents("../../games/$game.json", json_encode($json));
	}
}
?>
