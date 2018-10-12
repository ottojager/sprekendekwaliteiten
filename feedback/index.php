<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Start - Feedback - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/spelvorm2.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="stylesheet" href="../css/Feedback_background.css"type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<span class="alienBackLeft"></span>
		<span class="alienBackRight"></span>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		// create some variables to add header values
		$spelvorm = 'Feedback';
		$no_back_to_start = true;

		include('../header.php');
		?>
		<main class="container" id="main">
			<div class="startscherm">
				<h1 class="startscherm-content">Start - Feedback</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce finibus, ligula vitae egestas luctus, dolor nulla aliquet elit, a aliquam magna nulla at odio. Aenean volutpat lorem sed molestie iaculis. Integer volutpat sapien nulla. Duis volutpat egestas quam, vel blandit quam sodales ut. Nulla tristique quam eget enim blandit, at viverra urna luctus. Proin sagittis, magna vehicula ullamcorper elementum, erat metus scelerisque lectus, id vestibulum velit sem condimentum neque. Mauris venenatis imperdiet mi.</p>
			</div>
			<div class="button-positie">
				<div class="button"><button onclick="window.location='./join.php'">Speler</button></div>
				<div class="button"><button onclick="window.location='./create.php'">Spelleider</button></div>

				<?php
				if (isset($_SESSION['game_mode']) && $_SESSION['game_mode'] == 2) {
					if (isset($_SESSION['game_id'])) {
						$game = $_SESSION['game_id'];
						$json = json_decode(file_get_contents("./games/$game.json"), true);
						if ($json['game_started']) {
							echo '<div class="button"><button onclick="window.location=\'./game.php\'">Terug naar spel</button></div> ';
						} else {
							echo '<div class="button"><button onclick="window.location=\'./lobby.php\'">Terug naar lobby</button></div> ';
						}
						echo '<div class="button"><button onclick="window.location=\'./delete.php\'">Verwijder sessie</button></div>';
					}
				}
				?>
			</div>
		</main>
		<?php include('../footer.php'); ?>
	</body>
</html>
