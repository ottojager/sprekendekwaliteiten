<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Speelvorm 2</title>
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/spelvorm2.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<?php include('../header.php'); ?>
		<main class="container">
			<div class="startscherm">
				<h1 class="startscherm-content">Feedback spel</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce finibus, ligula vitae egestas luctus, dolor nulla aliquet elit, a aliquam magna nulla at odio. Aenean volutpat lorem sed molestie iaculis. Integer volutpat sapien nulla. Duis volutpat egestas quam, vel blandit quam sodales ut. Nulla tristique quam eget enim blandit, at viverra urna luctus. Proin sagittis, magna vehicula ullamcorper elementum, erat metus scelerisque lectus, id vestibulum velit sem condimentum neque. Mauris venenatis imperdiet mi.</p>
			
				<div class="button-positie">
					<a class="button" href="join.php">Speler</a>
					<a class="button" href="create.php">Spelleider</a>
				
					<?php
					if (isset($_SESSION['game_id'])) {
						$game = $_SESSION['game_id'];
						$json = json_decode(file_get_contents("./games/$game.json"), true);
						if ($json['game_started']) {
							echo '<a class="button" href="./game.php">Naar spelpel</a> ';
						} else {
							echo '<a class="button" href="./lobby.php">Naar spel</a> ';
						}
						echo '<a class="button" href="./delete.php">Verwijder sessie</a>';
					}
					?>
				</div>
			</div>
		<?php include('../footer.php'); ?>
	</body>
</html>
