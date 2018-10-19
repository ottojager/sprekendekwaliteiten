<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../../css/basis.css" type="text/css">
	<link rel="stylesheet" href="../../css/header.css" type="text/css">
	<link rel="stylesheet" href="../../css/footer.css" type="text/css">
	<link rel="stylesheet" href="../../css/spelvorm2.css" type="text/css">
</head>
<body>
	<?php
	$spelvorm = 'Feedback';
	$name = $_SESSION['player_name'];
	$in_sub_folder = true;

	include('../../header.php');
	?>
	<main id="main">
		<p class="success">De email is verstuurd</p>
		<div class="button">
			<button class="back-button" onclick="window.location='../index.php'">Terug naar home</button>
		</div>
	</main>
	<?php include('../../footer.php'); ?>
</body>
</html>
