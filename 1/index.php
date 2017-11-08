<html lang="nl=NL">
	<head>
		<script type="text/javascript">
			var cardStack =
				<?php
				$config = json_decode(file_get_contents('../database_config.json'), true); // load the db connection info
				$db = mysqli_connect($config['hostname'], $config['username'], $config['password']);

				mysqli_select_db($db, "kwalspelaccess");
				$sql = "SELECT * FROM cards";
				$result = mysqli_query($db, $sql);
				$array = array();
				while ($card = mysqli_fetch_assoc($result)) {
					$array[] = $card['name'];
				}
				echo json_encode($array);
				?>
			;
		</script>
		<script type="text/javascript" src="singleplayer.js" defer></script>
		<title>Bewustwording - Kwaliteitenspel</title>
		<link rel="stylesheet" href="stylesheet.css" type="text/css">
		<link rel="stylesheet" href="../main.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="Rainbow_placeholder.png">
	</head>
	<body>
		<h1>Kwaliteitenspel - Bewustwording</h1>
		<div id="top">
			<div id="huidig"><h2>Huidige kaart:</p><div id="current"></div></div>
		</div>
		<h2>Kaarten</h2>
		<ul>
			<li><button id="slot1"></button></li>
			<li><button id="slot2"></button></li>
			<li><button id="slot3"></button></li>
			<li><button id="slot4"></button></li>
			<li><button id="slot5"></button></li>
			<li><button id="slot6"></button></li>
			<li><button id="slot7"></button></li>
			<li><button id="slot8"></button></li>
		</ul>
		<a class="skiplink" href="#top">Naar huidige kaart</a>
		<div id="graveyard">
			<h2>Afval stapel</h2>
		</div>
		<button id="backButton" onclick="backButton(this)"><img src="Knop.png" alt="Ongedaan maken"></button>
		<button id="endGame" onclick="endGame()"></button>
	</body>
</html>
