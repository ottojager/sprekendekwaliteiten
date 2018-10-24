<!DOCTYPE html>
<html lang="nl">
	<head>
		<script src="./api/js/std.js" defer></script>
		<script>
		<?php
		// leader only JS
		if ($_SESSION['player_id'] == 11) { // if user is game leader
		?>
		function end_game() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.location.href = '../end/';
				}
			};
			xhttp.open("GET", "../api/end.php", true);
			xhttp.send();
		}

		<?php } // end leader only JS ?>
		var amount_players = <?php echo count($json['players']);?>;
		var own_id = <?php echo $_SESSION['player_id'];?>;
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
		include('../../header.php');
		?>
		<main class="container player-container" id="main" tabindex="-1">
			<h2>nieuwe kaart</h2>
			<div>
				<button><?php echo $json['current_card']; ?></button>
			</div>
			<button onlclick="window.location='./giveaway.php'">weggeven</button>
			<button onlclick="window.location='./trade.php'">inruilen</button>
			<h2>Jouw hand kaarten</h2>
			<ul>
				<div class="kaart-rij">
					<?php
					foreach($json['players'][ $_SESSION['player_id'] ]['hand'] as $key => $value) {
						echo "<li class=\"kaart eind-kaart\"><button>$value</button></li>";
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
