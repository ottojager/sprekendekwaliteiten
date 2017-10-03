<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Speelvorm 2</title>
		<link rel="stylesheet" href="css/index.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<a href="create.php">Maak lobby</a>
		<a href="join.php">Join lobby</a>
<?php	if (isset($_SESSION['game_id'])) {
			echo '<a href="./game.php">terug naar game</a> ';
			echo '<a href="./delete.php">delete session</a>';
		}?>
	</body>
</html>
