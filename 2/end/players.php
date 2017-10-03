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
	?>
	<a href="../delete.php">Game verlaaten</a>
</body>
</html>
