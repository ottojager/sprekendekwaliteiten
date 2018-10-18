<?php
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), true);
?>
<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Einde - Feedback - Sprekende Kwaliteiten</title>
	<!-- <link rel="stylesheet" href="../css/end.css" type="text/css"> -->
	<link rel="stylesheet" href="../../css/basis.css" type="text/css">
	<link rel="stylesheet" href="../../css/header.css" type="text/css">
	<link rel="stylesheet" href="../../css/footer.css" type="text/css">
	<link rel="stylesheet" href="../../css/feedback.css" type="text/css">
	<link rel="icon" sizes="16x16" type="image/png" href="/../kwal-spel/feedback/css/Rainbow_placeholder.png">
	<script src="./endgame.js"></script>
	<!-- <script>
	var card_list =
	<?php
	// just accept that this works
	// echo json_encode(
	// 	array(
	// 		$_SESSION['player_id'] => $json['players'][ $_SESSION['player_id'] ]['stack']
	// 	)
	// );
	?>
	</script> -->
</head>
<!-- javascript voor kaarten pagenation -->
<!-- onload="render_card_list(0, <?php // echo $_SESSION['player_id'] ?>, 8)" -->
<body>
	<?php
	// create some variables to add header values
	$spelvorm = 'Feedback';
	$name = $_SESSION['player_name'];
	$in_sub_folder = true;

	include('../../header.php');
	?>
	<main class="container" id="main" tabindex="-1">
		<h2>Ontvangen kaarten - Feedback</h2>
		<div id="card-list-container">
			<div class="kaart-rij">
				<?php
				foreach($json['players'][ $_SESSION['player_id'] ]['stack'] as $key => $value) {
					if ($key % 4 == 0 && $key != 0) {
						echo "</div>";
						echo "<div class=\"kaart-rij\">";
					}
					echo "<li class=\"kaart eind-kaart\"><button>$value</button></li>";
				}
				?>
			</div>
		</div>
	</main>
	<?php include('../../footer.php'); ?>
</body>
</html>
