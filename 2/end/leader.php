<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Speelvorm 2</title>
	<link rel="stylesheet" href="/kwaliteiten/2/css/end.css" type="text/css">
	<link rel="icon" sizes="16x16" type="image/png" href="/../kwal-spel/2/css/Rainbow_placeholder.png">
</head>
<body>
	<?php
	foreach ($json['players'] as $key => $player) {
		echo '<p>'.$player['name'].':</p>';
		echo '<ul>';
		foreach ($player['stack'] as $key => $value) {
			echo "<li>$value</li>";
		}
		echo '</ul>';
	}
	?>
	<a href="../delete.php">Game verlaten</a>
</body>
</html>
