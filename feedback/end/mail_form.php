<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../../css/basis.css" type="text/css">
	<link rel="stylesheet" href="../../css/header.css" type="text/css">
	<link rel="stylesheet" href="../../css/footer.css" type="text/css">
	<link rel="stylesheet" href="../../css/spelvorm2.css" type="text/css">
	<script src="./endgame.js"></script>
</head>
<body>
	<?php
	$spelvorm = 'Feedback';
	$name = $_SESSION['player_name'];
	$in_sub_folder = true;

	include('../../header.php');
	?>
	<main id="main">
		<div class="email-container">
			<span class="alienBackLeft"></span>
			<span class="alienBackRight"></span>
			<div class="form-email">
				<label for="email">E-mail</label>
				<input id="email" class="form-input" type="email" autofocus>
				<p id="error"></p>
			</div>
			<div class="button">
				<button class="send-button" onclick="send_mail()">Stuur e-mail</button>
			</div>
			<div class="button">
				<button class="back-button" onclick="window.location='../index.php'">Terug naar home</button>
			</div>
		</div>
	</main>
	<?php include('../../footer.php'); ?>
</body>
</html>
