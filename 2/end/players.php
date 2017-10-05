<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Speelvorm 2</title>
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
		echo '<a href="?p='.$value['player_id'].'">'.$value['name'].'</a> ';
	}
	?>

	<a href="../delete.php">Game verlaten</a>
</body>
</html>
