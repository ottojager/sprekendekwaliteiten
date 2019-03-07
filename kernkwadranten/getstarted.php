<?php
require('../functions.php');
session_start();
?>
<html lang="nl">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
        <link rel="stylesheet" href="../css/footer.css" type="text/css">
        <link rel="stylesheet" href="../css/spelvorm4.css" type="text/css">
        <script src="./js/scripts.js" type="text/javascript"></script>
        <script>
            var selectedCards = [];
        </script>
		<title>Kies 3 kwaliteiten - Kernkwadranten - Sprekende Kwaliteiten</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		$spelvorm = 'Kernkwadranten';

		require('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
        <div id="hand">
	<h1>Kies jouw 3 belangrijkste kwaliteiten</h1>
	<ul>
        <?php
        $totalIndex = 0;
        $cards = $_SESSION['kernkwadrant_results'];
        $keys = array_keys($cards);

        if (count($cards) >= 4) {
            for ($i = 0; $i < floor(count($cards) / 4); $i++) {
                echo '<div class="kaart-rij">';
                for ($j = 0; $j < 4; $j++) {
                    echo '<li class="kaart"><button onclick="selectCard(this)"><p>' . $keys[$totalIndex] . '</p></button></li>';
                    $totalIndex++;
                }
                echo '</div>';
            }
        }
        if ((count($cards) % 4) > 0) {
            echo '<div class="kaart-rij">';
            for ($i = 0; $i < (count($cards) % 4); $i++) {
                echo '<li class="kaart"><button onclick="selectCard(this)"><p>' . $keys[$totalIndex + $i] . '</p></button></li>';
            }
            echo '</div>';
        }
        ?>
	</ul>
</div>
<div class="bottom-menu">
	<div class="button"><button onclick="confirmCardSelections()">Maak kernkwadranten</button></div>
	<div class="button"><button class="back-button" onclick="window.location='../index.php'">Terug naar Home</button></div>
</div>

		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
