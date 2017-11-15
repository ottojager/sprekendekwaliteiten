<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Einde - Feedback - Speelvorm 2</title>
	<link rel="stylesheet" href="/kwaliteiten/2/css/end.css" type="text/css">
	<link rel="icon" sizes="16x16" type="image/png" href="/../kwal-spel/2/css/Rainbow_placeholder.png">
</head>
<body>
	<?php
	echo '<p>'.$player['name'].':</p>';
	echo '<ul>';
	foreach ($player['stack'] as $key => $value) {
		echo "<li>$value</li>";
	}
	echo '</ul>';

	foreach ($json['players'] as $key => $value) {
		if ($value['name'] != 'Afval stapel') {
			echo '<a href="?p='.$value['player_id'].'">'.$value['name'].'</a> ';
		}
	}
	?>

	<a href="../delete.php">Spel verlaten</a>
</body>
</html>
