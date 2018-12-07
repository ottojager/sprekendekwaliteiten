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

			// check if it's that players turn and redirect them to the current
			// player version of the page
			if (game_info['current_player'] == own_id) {
				window.location = './';
			}

			// update page content
			document.getElementById('current_player_indicator').innerHTML =
			game_info['players'][game_info['current_player']]['name']+" is aan de beurt...";
		}
		</script>
		<meta charset="utf-8">
		<title>Actief - Combi - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="../../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../../css/header.css" type="text/css">
		<link rel="stylesheet" href="../../css/footer.css" type="text/css">
		<link rel="stylesheet" href="../../css/spelvorm3.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="../css/Rainbow_placeholder.png">
	</head>
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		include('../../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
		<?php
		if ($_SESSION['player_id'] < 11)
		{?>
			<h2 id="current_player_indicator"><?php echo $json['players'][$json['current_player']]['name'] ?> is aan de beurt...</h2>
			<h3 class="speler-beurt">Jouw kaarten</h3>
			<ul>
				<div class="kaart-rij">
					<?php
					foreach($json['players'][$_SESSION['player_id']]['hand'] as $key => $value) {
						echo "<li class=\"kaart eind-kaart\"><button>$value</button></li>";
					}
					?>
				</div>
			</ul>
  <?php } ?>
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
