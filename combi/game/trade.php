<?php
session_start();


if (!isset($_SESSION['game_id'])) {
	header('Location: ../');
}
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);
if ($json['game_started'] == false) {
	header('location: ../lobby.php');
}
?>
<!DOCTYPE html>
<html lang="nl">
	<head>
		<script src="./api/js/std.js" defer></script>
		<script>
		var amount_players = <?php echo count($json['players']);?>;
		var own_id = <?php echo $_SESSION['player_id'];?>;

		function update_page_view() {
			// this funtion implements page updating
			// it will be called by update_view() in std.js everytime the game's
			// json file is updated

			// in the case of this page, we check if the current_player has changed during our
			// own turn, if that's the case, we will want to be sent to the hand.php page instead
			// this scenario can occur if the game leader undoes a move
			if (game_info['current_player'] != own_id) {
				window.location = './';
			}
		}
		</script>
		<meta charset="utf-8">
		<title>Actief - Feedback - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="../../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../../css/header.css" type="text/css">
		<link rel="stylesheet" href="../../css/footer.css" type="text/css">
		<link rel="stylesheet" href="../../css/spelvorm3.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="../css/Rainbow_placeholder.png">
	</head>
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		// create some variables to add header values
		$spelvorm = 'Combi';
		$name = $_SESSION['player_name'];

		require('../../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
			<div class="linker-menu">
				<h2>Nieuwe kaart</h2>
				<div class="eind-kaart">
					<button id="current_swap_card"><?php echo $json['current_card']; ?></button>
				</div>
				<div class="button">
					<button onclick="undo_visual_swap()">Ongedaan maken</button>
				</div>
				<div class="button">
					<button onclick="window.location='./'" id="back_without_trade_btn">Terug zonder ruilen</button>
				</div>
				<div class="button" id="confirm_swap_button">
					<button onclick="confirm_swap()" id="confirm_btn">Bevestig ruil</button>
				</div>
			</div>
			<h2 id="swap_text">Selecteer een kaart die je wilt inruilen</h2>
			<ul>
				<div class="kaart-rij">
					<?php
					foreach($json['players'][$_SESSION['player_id']]['hand'] as $key => $value) {
						echo "<li class=\"kaart\"><button onclick=\"swap_card(this, $key, '$value')\">$value</button></li>";
					}
					?>
				</div>
			</ul>
		</main>
		<?php include('../../footer.php') ?>
	</body>
</html>
<?php
// adding listeners
if ($_SESSION['player_id'] == 11) {
?>
<script>
// leader_card(amount_players);
</script>
<?php } ?>
