<?php session_start();
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);
 ?>
<!DOCTYPE html>
<html lang="nl">
<head>
	<link rel="stylesheet" href="../../css/basis.css" type="text/css">
	<link rel="stylesheet" href="../../css/header.css" type="text/css">
	<link rel="stylesheet" href="../../css/footer.css" type="text/css">
	<link rel="stylesheet" href="../../css/spelvorm3.css" type="text/css">
	<script src="endgame.js" type="text/javascript"></script>
	<script type="text/javascript">
		var cards = <?= json_encode($json['players'][$_SESSION['player_id']]['hand']) ?>;
		//I don't remember why, but the first item had(?) to be null, so:
		cards.unshift(null);
	</script>
</head>
<body>
	<?php
	$spelvorm = 'Feedback';
	$name = $_SESSION['player_name'];
	$in_sub_folder = true;

	require('../../header.php');
	?>
	<main id="main">
		<p class="success">De email is verstuurd</p>
		<div class="button">
			<button class="back-button" onclick="window.location='../index.php'">Terug naar home</button>
		</div>
		<div class="button">
			<button onclick="startGameMode4()">Maak kernkwadranten</button>
		</div>
	</main>
	<?php include('../../footer.php'); ?>
</body>
</html>
