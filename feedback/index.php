<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Start - Feedback - Sprekende Kwaliteiten</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

		include('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
			<div class="startscherm">
				<h2 class="startscherm-content">Speel het spel "Feedback"</h2>
				<p>Het spel "Feedback" speel je met minimaal één andere speler samen. Het spel wordt geleid door een spelleider (meestal je coach of trainer). De spelleider maakt een "spelsessie" aan en kiest het aantal kaarten waarmee gespeeld wordt. De spelleider krijgt een code, die hij/zij uitdeelt aan de spelers. Hiermee kunnen de spelers deelnemen aan het spel.</p>
				<p>Telkens is één van de spelers aan de beurt. Die speler krijgt een kaart met een kwaliteit of vervorming daarop. Deze kaart geeft de speler aan één van de andere spelers bij wie hij deze kwaliteit of vervorming vindt passen. Dit doet hij/zij door die speler te selecteren (klik of enter). De speler die aan de beurt is, mag de kaart ook wegleggen, als de kwaliteit of vervorming bij niemand past.</p>
				<p>Als de kaarten op zijn, eindigt het spel. De spelleider kan het spel ook tussentijds beëindigen. Elke speler ziet dan de kaarten die hij/zij heeft ontvangen en die dus als "feedback" van de andere spelers heeft gekregen. Je kunt deze resultaten aan jezelf laten sturen.</p>
				<p>Veel plezier met het spel!</p>
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
