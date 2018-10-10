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
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		// create some variables to add header values
		$spelvorm = 'Combi';
		$no_back_to_start = true;

		include('../header.php');
		?>
		<main class="container" id="main">
			<div class="startscherm">
				<h1 class="startscherm-content">Start - Combi</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce finibus, ligula vitae egestas luctus, dolor nulla aliquet elit, a aliquam magna nulla at odio. Aenean volutpat lorem sed molestie iaculis. Integer volutpat sapien nulla. Duis volutpat egestas quam, vel blandit quam sodales ut. Nulla tristique quam eget enim blandit, at viverra urna luctus. Proin sagittis, magna vehicula ullamcorper elementum, erat metus scelerisque lectus, id vestibulum velit sem condimentum neque. Mauris venenatis imperdiet mi.</p>
			</div>
			<div class="button-positie">
				<div class="button"><button>Speler</button></div>
				<div class="button"><button>Spelleider</button></div>
			</div>
			<!-- if (isset($_SESSION['game_mode'] && $_SESSION['game_mode'] == 3)) {
			we will need this if later when I implement the extra
			buttons for when someone is in an ongoing game
			- niels -->
		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
