<?php
session_start();

function cmp($a, $b) {
	return ($a['player_id'] < $b['player_id']) ? -1 : 1;
}
// kicks a player from the game
// can only be used in the lobby
if ($_SESSION['player_id'] == 11 && isset($_SESSION['game_id'])) {
	if (isset($_GET['p'])) {
		$game = $_SESSION['game_id'];
		$json = json_decode(file_get_contents("../games/$game.json"), true);

		if (!$json['game_started']) {
			// just remove the user it's fine
			unset($json['players'][ $_GET['p'] ]);
			usort($json['players'], "cmp");  // TODO: add a better comment about this line
			foreach ($json['players'] as $key => $value) {
				$json['players'][$key]['player_id'] = $key;
			}

			file_put_contents("../games/$game.json", json_encode($json));
		}
		header('HTTP/1.1 400 Bad Request');
	}
} else {
	header('HTTP/1.1 403 Forbidden');
}
?>
