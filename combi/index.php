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

		include('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
			<div class="startscherm">
				<h2 class="startscherm-content">Speel het spel "Combi"</h2>
				<p>Het spel "Combi" is een combinatie van de spellen "Bewustwording" en "Feedback". Dit spel speel je met minimaal één andere speler samen. Het spel wordt geleid door een spelleider (meestal je coach of trainer). De spelleider maakt een "spelsessie" aan en kiest het aantal kaarten waarmee gespeeld wordt. De spelleider krijgt een code, die hij/zij uitdeelt aan de spelers. Hiermee kunnen de spelers deelnemen aan het spel.</p><br />
				<p>Telkens is één van de spelers aan de beurt. Die speler krijgt een kaart met een kwaliteit of vervorming daarop. Elke speler heeft daarnaast <strong>vijf</strong> handkaarten gekregen. De speler die aan de beurt is mag de nieuwe (ontvangen) kaart inruilen met één van zijn vijf handkaarten óf deze kaart aan één van de andere spelers geven bij wie hij deze kwaliteit of vervorming vindt passen. Dit doet hij/zij door die speler te selecteren (klik of enter).</p>
				<p>De kaarten die een speler van de andere spelers ontvangt, komen naast zijn vijf handkaarten (dus niet in plaats daarvan).</p>
				<p>Als de kaarten op zijn, eindigt het spel. De spelleider kan het spel ook tussentijds beëindigen. Elke speler ziet dan de kaarten die hij/zij zelf heeft overgehouden als handkaarten plus de kaarten die hij/zij van de anderen heeft ontvangen als "feedback". Je kunt deze resultaten aan jezelf laten sturen.</p>
				<p>Veel plezier met het spel!</p>
			</div>
			<div class="button-positie">
				<div class="button"><button onclick="window.location='./join.php'">Speler</button></div>
				<div class="button"><button onclick="window.location='./create.php'">Spelleider</button></div>
			</div>
			<!-- if (isset($_SESSION['game_mode'] && $_SESSION['game_mode'] == 3)) {
			we will need this if later when I implement the extra
			buttons for when someone is in an ongoing game
			- niels -->
		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
