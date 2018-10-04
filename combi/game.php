<?php
session_start();


if (!isset($_SESSION['game_id'])) {
	header('Location: ./');
}

$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("./games/$game.json"), true);
if ($json['game_started'] == false) {
	header('location: ./lobby.php');
}

// reset player_id values so they match again
// also check if they player has been kicked or not and redirect those back to the home screen
if ($_SESSION['player_id'] != 11) {
	$kicked = true; // used to check if the player may have been kicked
	foreach ($json['players'] as $key => $value) {
		if ($value['name'] == $_SESSION['player_name']) {
			$_SESSION['player_id'] = $value['player_id'];
			$kicked = false;
		}
	}
	if ($kicked) {
		header('Location: ./delete.php'); // delete the player we don't care
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Actief - Combi - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="./css/game.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<?php include('../header.php'); ?>
		<?php if ($_SESSION['player_id'] != 11) {
		/////////////
		// players //
		/////////////
		?>
		<div id="container" class="player-container">
			<div id="card_display">
				<p id="current_card"><?php echo $json['current_card']; ?></p>
			</div>

			<ul id="player_list">
				<?php
				foreach ($json['players'] as $key => $value) {
					if ($value['name'] != 'Afval stapel') {
						echo '<li id="'.$value['player_id'].'"><button>'.$value['name'].' ('.count($value['stack']).')</button></li>';
					}
				}
				?>
			</ul>
			<button id="<?php echo count($json['players'])-1 ?>" onclick="reply_click(<?php echo count($json['players'])-1 ?>)">Afval stapel</button>

			<button onclick="received_cards_view()">Ontvangen kaarten</button>
		<?php } else {
		/////////////////
		// game leader //
		/////////////////
		?>
		<div id="container" class="leader-container">
			<div id="card_display">
				<p id="current_card"><?php // echo $json['current_card']; ?></p>
			</div>

			<ul id="player_list">
				<?php
				foreach ($json['players'] as $key => $value) {
					if ($value['name'] != 'Afval stapel') {
						echo '<li id="'.$value['player_id'].'"><button>'.$value['name'].' ('.count($value['stack']).')</button></li>';
					}
				}
				?>
			</ul>
			<p>nog <?php echo count($json['card_stack']); ?> kaarten over.</p>
			<div id="card_stack">
				<p>Click op de naam van een speler om hier hun kaarten te zien.</p>
			</div>
			<button onclick="end_game()">Spel beëindigen</button>
			<button onclick="undo()">Ongedaan maken</button>
			<button id="<?php echo count($json['players'])-1 ?>" onclick="leader_view_cards(<?php echo count($json['players'])-1 ?>)">Afval stapel</button>
		<?php } ?>
		<?php include('../footer.php'); ?>
	</body>
</html>
