<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Speelvorm 2</title>
		<link rel="stylesheet" href="../css/basic.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<?php include('../header.php'); ?>
		<h1>Feedback spel</h1>
		<p>Lorum Ipsum</p>
		<a href="join.php">Speler</a>
		<a href="create.php">Spelleider</a>
<?php	if (isset($_SESSION['game_id'])) {
			$game = $_SESSION['game_id'];
			$json = json_decode(file_get_contents("./games/$game.json"), true);
			if ($json['game_started']) {
				echo '<a href="./game.php">terug naar game</a> ';
			} else {
				echo '<a href="./lobby.php">terug naar game</a> ';
			}
			echo '<a href="./delete.php">delete session</a>';
		}
		include('../footer.php'); ?>
	</body>
</html>
