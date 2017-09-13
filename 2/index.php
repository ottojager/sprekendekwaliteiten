<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Speelvorm 2</title>
	</head>
	<body>
		<a href="create.php">Maak lobby</a>
		<a href="join.php">Join lobby</a>
		<?php if (isset($_SESSION['game_id'])) { echo '<a href="./delete.php">delete session</a>';}?>
	</body>
</html>
