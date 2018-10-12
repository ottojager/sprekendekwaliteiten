<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Einde - Feedback - Sprekende Kwaliteiten</title>
	<link rel="stylesheet" href="../../css/basis.css" type="text/css">
	<link rel="stylesheet" href="../../css/header.css" type="text/css">
	<link rel="stylesheet" href="../../css/footer.css" type="text/css">
	<link rel="icon" sizes="16x16" type="image/png" href="/../kwal-spel/feedback/css/Rainbow_placeholder.png">
	<script src="./endgame.js"></script>
	<script>
	var card_list =
	<?php
	foreach ($json['players'] as $key => $value) {
		$array[$key] = $value['stack'];
	}
	echo json_encode($array);
	?>
	</script>
</head>
<!-- javascript voor kaarten pagenation -->
<!-- onload="leader_initial_rendering_calls(<?php echo count($json['players']) -1; ?>)" -->
<body>
	<?php
	// create some variables to add header values
	$spelvorm = 'Feedback';
	$name = $_SESSION['player_name'];
	$in_sub_folder = true;

	include('../../header.php');
	?>
	<div id="container">
		<h2>Einde - Feedback</h2>
		<?php
		foreach ($json['players'] as $key => $player) {
			if ($player['name'] != 'Afval stapel') {
				echo "<div id=\"card-list-container-$key\"></div>";
			}
		}
		?>
		<p>De spelers kunnen hun ontvangen kaarten per e-mail ontvangen en aan jou als spelleider doorsturen.</p>
		<a href="../delete.php">Spel verlaten</a>
	</div>
	<?php include('../../footer.php'); ?>
</body>
</html>
