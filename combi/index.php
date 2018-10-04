<!DOCTYPE html>
<html>
	<head>
		<title>Start - Combi - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/spelvorm3.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<?php
		// create some variables to add header values
		$spelvorm = 'Combi';

		include('../header.php');
		?>
		<main class="container">
			<div class="startscherm">
				<h1 class="startscherm-content">Combi spel</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce finibus, ligula vitae egestas luctus, dolor nulla aliquet elit, a aliquam magna nulla at odio. Aenean volutpat lorem sed molestie iaculis. Integer volutpat sapien nulla. Duis volutpat egestas quam, vel blandit quam sodales ut. Nulla tristique quam eget enim blandit, at viverra urna luctus. Proin sagittis, magna vehicula ullamcorper elementum, erat metus scelerisque lectus, id vestibulum velit sem condimentum neque. Mauris venenatis imperdiet mi.</p>
			</div>
			<div class="button-positie">
				<div class="button"><a href="join.php"><button>Speler</button></a></div>
				<div class="button"><a href="create.php"><button>Spelleider</button></a></div>
			</div>
			<!-- if (isset($_SESSION['game_mode'] && $_SESSION['game_mode'] == 3)) {
			we will need this if later when I implement the extra
			buttons for when someone is in an ongoing game
			- niels -->
		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
