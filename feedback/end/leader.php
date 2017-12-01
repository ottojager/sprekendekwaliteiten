<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Einde - Feedback - Speelvorm 2</title>
	<link rel="stylesheet" href="../css/end.css" type="text/css">
	<link rel="icon" sizes="16x16" type="image/png" href="/../kwal-spel/2/css/Rainbow_placeholder.png">
</head>
<body>
	<div id="topbar"></div>
	<div id="sidetopbar">
		<div id="borderimage"></div>
		<div id="player__name"></div>
	</div>
	<div id="container">
		<h1>Einde - Feedback - Speelvorm 2</h1>
		<?php
		foreach ($json['players'] as $key => $player) {
			if ($player['name'] != 'Afval stapel') {
				echo '<p>'.$player['name'].':</p>';
				echo '<ul>';
				foreach ($player['stack'] as $key => $value) {
					echo "<li>$value</li>";
				}
				echo '</ul>';
			}
		}
		?>
		<a href="../delete.php">Spel verlaten</a>
	</div>
</body>
</html>
