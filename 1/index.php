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
		<title>Speelvorm 1</title>
		<link rel="stylesheet" href="stylesheet.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="Rainbow_placeholder.png">
	</head>
	<body>
		<div id="top">
			<div id="huidig"><p>Huidige kaart:</p><div id="current"></div></div>
			<button id="backButton" onclick="backButton(this)"><img src="Knop.png" alt="Ongedaan maken"></button>
		</div>
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
		<div id="graveyard">Afval stapel</div>
		<button id="endGame" onclick="endGame()"></button>
	</body>
</html>
