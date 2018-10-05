<html lang="nl=NL">
	<head>
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/email-form.css" type="text/css">
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
		<title>Nieuwe kaart - Bewustwording - Sprekende Kwaliteiten</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/spelvorm1.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="Rainbow_placeholder.png">
	</head>
	
	<body onbeforeunload="return confirm('Weet u zeker dat u de pagina wilt sluiten?')">
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		// create some variables to add header values
		$spelvorm = 'Bewustwording';

		include('../header.php');
		?>
		<main class="container" id="main">

		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
