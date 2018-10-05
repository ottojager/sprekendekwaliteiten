<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<meta charset="utf-8">
		<link rel="icon" sizes="16x16" type="image/png" href="bewustwording/Rainbow_placeholder.png">
		<link rel="stylesheet" href="./css/basis.css" type="text/css">
		<link rel="stylesheet" href="./css/header.css" type="text/css">
		<link rel="stylesheet" href="./css/footer.css" type="text/css">
		<title>Kwaliteitenspel</title>
	</head>
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		$no_back_to_start = true;

		include('header.php')
		?>
		<main class="container" id="main">
			<h1>Kwaliteitenspel</h1>
			<h2>Welkom bij het Kwaliteitenspel</h2>
			<p></p>
			<div id="knoppen">
				<div class="button"><a href="./bewustwording/"><button>Bewustwording</button></a></div>
				<div class="button"><a href="./feedback/"><button>Feedback</button></a></div>
				<div class="button"><a href="./combi/"><button>Combi</button></a></div>
			</div>
		</main>
		<?php include('footer.php') ?>
	</body>
</html>
