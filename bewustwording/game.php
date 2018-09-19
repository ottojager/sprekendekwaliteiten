<html lang="nl=NL">
	<head>
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<script type="text/javascript">
			var cardStack =
				<?php
				$config = json_decode(file_get_contents('../.env.json'), true); // load the db connection info
				$db = mysqli_connect($config['hostname'], $config['username'], $config['password']);

				mysqli_select_db($db, $config['database']);
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
		<link rel="stylesheet" href="../css/spelvorm1.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="Rainbow_placeholder.png">
	</head>
	<body>
		<?php include('../header.php') ?>
		<div id="topbar"></div>
		<div id="help">
			<div id="borderimage"></div>
			<div id="player__name"></div>
		</div>
		<h1>Kwaliteitenspel - Bewustwording</h1>
		<div id="container">

		</div>
		<?php include('../footer.php') ?>
	</body>
</html>
