<html lang="nl=NL">
	<head>
		<script type="text/javascript">
			var cardStack =
				<?php
				$config = json_decode(file_get_contents('../database_config.json'), true); // load the db connection info
				$db = mysqli_connect($config['hostname'], $config['username'], $config['password']);

				mysqli_select_db($db, "k26431_kwalspel");
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
		<div id="topbar"></div>
		<div id="help">
			<div id="borderimage"></div>
			<div id="player__name"></div>
		</div>
		<div id="container">
			<h1>Kwaliteitenspel - Bewustwording</h1>
			<div id="actievekaart" class="row">
				<h2 class="col-md-offset-2 col-xs-1 col-sm-2 col-sm-offset-1 col-xs-offset-1">Actieve kaart:</h2>
				<div id="huidig" class="col-xs-11 col-sm-6 col-md-4"><p id="current"></p></div>
			</div>
			<div id="kaarten">
			<h2 id="jkaart">Jouw 8 kaarten</h2>
			<ul>
				<div class="row">
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot1" class="kaart"><p></p></button></li>
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot2" class="kaart"><p></p></button></li>
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot3" class="kaart"><p></p></button></li>
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot4" class="kaart"><p></p></button></li>
				</div>
				<div class="row">
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot5" class="kaart"><p></p></button></li>
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot6" class="kaart"><p></p></button></li>
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot7" class="kaart"><p></p></button></li>
					<li class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="slot8" class="kaart"><p></p></button></li>
				</div>
			</ul>
			</div>

			<div class="row" id="knoppen">
				<div class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="backButton" onclick="backButton(this)"><p>Ongedaan maken</p></button></div>
				<div class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><a class="skiplink" id="skiplink" href="#current">Naar actieve kaart</a></div>
				<div class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="trash"><p>Kaart weggooien</p></button></div>
				<div class="col-xs-10 col-xs-offset-2 col-sm-5 col-sm-offset-1 col-md-3 col-md-offset-0"><button id="endGame" onclick="endGame(false)"><p>Be&#235;indig spel</p></button></div>
			</div>
			<div class="row">
				<h2 id="aflegstapel">Aflegstapel</h2>
			</div>
			<ul class="col-xs-12 col-sm-6 col-md-3" id="graveyard">

			</ul>
		</div>
	</body>
</html>
