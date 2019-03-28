<?php
require('../functions.php');
session_start();
$gameType = -1;
if (isset($_GET['type'])) {
	$type = $_GET['type'];
	
	if (is_numeric($type)) {
		$gameType = $type;
	}
}
?>
<html lang="nl">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/email-form.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<script type="text/javascript">
			var cardStack = <?= json_encode(getAllCards($gameType)); ?>;
		</script>
		<script type="text/javascript" src="singleplayer.js" defer></script>
		<title>Nieuwe kaart - Bewustwording - Sprekende Kwaliteiten</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/spelvorm1.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="Rainbow_placeholder.png">
	</head>
	
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		// create some variables to add header values
		$spelvorm = 'Bewustwording';

		require('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">

		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
