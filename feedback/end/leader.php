<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Einde - Feedback - Sprekende Kwaliteiten</title>
	<link rel="stylesheet" href="../css/end.css" type="text/css">
	<link rel="icon" sizes="16x16" type="image/png" href="/../kwal-spel/feedback/css/Rainbow_placeholder.png">
</head>
<body>
	<div id="topbar"></div>
	<div id="sidetopbar">
		<div id="borderimage"></div>
		<div id="player__name">Spelleider</div>
	</div>
	<div id="container">
		<h1>Einde - Feedback</h1>
		<?php
		foreach ($json['players'] as $key => $player) {
			if ($player['name'] != 'Afval stapel') {
				echo '<h2>'.$player['name'].':</h2>';
				echo '<ul>';
				foreach ($player['stack'] as $key => $value) {
					echo "<li>$value</li>";
				}
				echo '</ul>';
			}
		}
		?>
		<p>De spelers kunnen hun ontvangen kaarten per e-mail ontvangen en aan jou als spelleider doorsturen.</p>
		<a href="../delete.php">Spel verlaten</a>
	</div>
</body>
</html>
