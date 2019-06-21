<?php
session_start();
$GLOBALS['bewustwording_authenticated'] = false;
?>
<!DOCTYPE html>
<html lang="nl">
	<head>
		<title>Start - Bewustwording - Sprekende Kwaliteiten</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/spelvorm1.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="stylesheet" href="../css/Bewustwording_background.css"type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">

		<script type="text/javascript">
		var gameType = 1;
		window.addEventListener('load', function() {
			var paramValue = new URL(window.location.href).searchParams.get('error');
			console.log(paramValue);
			if (paramValue != null)
			{
				console.log('hm');
				document.getElementById('error').innerText = paramValue;
			}
		});
		</script>
	</head>
	<body>
	<span class="alienBackLeft"></span>
	<span class="alienBackRight"></span>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		// create some variables to add header values
		$spelvorm = 'Bewustwording';

		require('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
			<div class="startscherm">
				<h2 class="startscherm-content">Speel het spel "Bewustwording"</h2>
				<p>Het spel "Bewustwording" speel je alleen, of samen met  een coach of trainer. Je krijgt telkens een nieuwe kaart. Daarnaast heb je 8 willekeurige "handkaarten" gekregen. De nieuwe (ontvangen) kaart kun je meteen weggooien of inruilen met één van de 8 handkaarten.<br />Om in te ruilen, selecteer je de knop "inruilen". Je ziet dan je 8 handkaarten. Als de nieuwe kaart beter bij jou past dan één van de handkaarten, selecteer je die kaart om in te ruilen. De nieuwe kaart komt dus voor de geselecteerde handkaart in de plaats. Zo nodig kun je dit ongedaan maken.</p>
				<p>Als je alle kaarten gehad hebt, eindigt het spel. Je kunt het spel ook tussentijds beëindigen. Je ziet dan de 8 kaarten die jij hebt gekozen en die dus het beste bij jou passen. Je kunt deze resultaten aan jezelf laten sturen.</p>
				<p>Veel plezier met het spel!</p>
				<br><br>
			</div>
			<form method="POST" action="./game.php">
			<p id="error"></p>
				<div class="red_border">
					<div class="formfield">
						<label for="name">Naam:</label><input id="name" type="text" name="name">
						<br>
						<label for="password">Wachtwoord:</label><input id="password" type="password" name="password">
					</div>
					<input type="radio" name="gametype" value="1" checked>Zonder valkuilen
				<input type="radio" name="gametype" value="3">Met valkuilen
			<div class="bottom-menu">
				<div class="button"><button type="submit" class="button" value="Start spel">Spel Starten</div>
			</div>
			</form>
		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
