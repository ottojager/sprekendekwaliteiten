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
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="stylesheet.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="Rainbow_placeholder.png">
	</head>
	<body>
		<h1>Kwaliteitenspel - Bewustwording</h1>
		<div id="top" class="row">
			<h2 class="col-xs-1 col-sm-2 col-sm-offset-2" style="text-align: right;">Actieve kaart:</h2>
			<div id="huidig" class="col-xs-11 col-sm-6 col-md-4"><img src="kaart-liggend_goed.png"><div id="current"></div></div>
		</div>
		<div>
		<h2 id="jkaart">Jouw 8 kaarten</h2>
		<ul>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot1"></button></li>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot2"></button></li>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot3"></button></li>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot4"></button></li>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot5"></button></li>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot6"></button></li>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot7"></button></li>
			<li class="col-xs-12 col-sm-6 col-md-3"><img src="kaart-liggend_goed.png"><button id="slot8"></button></li>
		</ul>
		</div>
		<div style="clear: both;"></div>
		<div id="onmaken" class="col-xs-12 col-sm-6 col-md-3"><img src="knop_goed.png" alt="Ongedaan maken"><button id="backButton" onclick="backButton(this)">Ongedaan maken</button></div>
		<div class="col-xs-12 col-sm-6 col-md-3"><a class="skiplink" href="#current">Naar actieve kaart</a></div>
		<div id="eindspel" class="col-xs-12 col-sm-6 col-md-3"><img src="knop_goed.png" alt="Beëindig spel"><button id="endGame" onclick="endGame()">Be&#235;indig spel</button></div>
		<ul class="col-xs-12 col-sm-6 col-md-3" id="graveyard" style="clear:both;">
			<li><h2>Afleg stapel</h2></li>
		</ul>
	</body>
</html>
