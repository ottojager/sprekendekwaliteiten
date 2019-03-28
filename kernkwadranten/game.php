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
        <script>
            var playerKwaliteiten = <?= json_encode($_SESSION['kernkwadrant_results']);?>;
            var allKwaliteiten = <?= json_encode(getAllCards(CardOptions::Kwaliteiten));?>;
            var allValkuilen = <?= json_encode(getAllCards(CardOptions::Valkuilen));?>;
            var activeCarousel = allValkuilen;
            var indices = {};
            var cardTypes = {1:"valkuil", 2:"uitdaging", 3:"allergie"};
            var ids = {0: "kernkwaliteitCard", 1: "valkuilCard", 2: "uitdagingCard", 3: "allergieCard"};
            var questions = {1: "Welke eigenschap heb jij als je jouw kwaliteit te veel inzet?",
            2: "Wat is voor jou een uitdaging bij deze valkuil?",
            3: "Voor welke eigenschap van een ander ben jij allergisch?"};
            
            var FINISH_KWADRANT = "Klik op 'Voltooi kernkwadrant' om door te gaan!";
            var currentKernkwaliteitIndex = 0;
            var currentKwadrantIndex = -1;
            var carouselIndex = 0;
            
            var counter = -1;
            for (var key in playerKwaliteiten) {
                indices[++counter] = key;
            }

            window.addEventListener('load', function() {
                startGame();
            });
        </script>
        <script src="./js/scripts.js" type="text/javascript" defer></script>
		<title>Maak kwadranten - Kernkwadranten - Sprekende Kwaliteiten</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		$spelvorm = 'Kernkwadranten';

		require('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
            <h1>Kernkwadrant maken bij '<span id="currentCardTitle"></span>'</h1>
            <ul>
                <div class="kaart-rij">
                <li class="kwadrant-kaart-box"><h3>Kernkwaliteit</h3><div><p id="kernkwaliteitCard"></p></div></li>
                <span class="kwadrant-arrow">→</span>
                <li class="kwadrant-kaart-box"><h3>Valkuil</h3><div><p id="valkuilCard"></p></div></li>
                <br/>
                <div class="kwadrant-arrow-vertical">↑</div>
                <div class="kwadrant-arrow-vertical">↓</div>    
            </div>
                <div class="kaart-rij">
                <li class="kwadrant-kaart-box"><h3>Allergie</h3><div><p id="allergieCard"></p></div></li>
                <span class="kwadrant-arrow">←</span>
                <li class="kwadrant-kaart-box"><h3>Uitdaging</h3><div><p id="uitdagingCard"></p></div></li>
                </div>
            </ul>
            <br/>
            <h2 id="kwadrantQuestion"></h2>
            <ul>
                <div class="kaart-rij">
                    <?php 
                        for ($i = 0; $i < 5; $i++) {
                            echo '<li class="kaart"><button onclick="nextKwadrantPick(this);"><p class="carousel-card-text"></p></button></li>';
                        }
                    ?>
                </div>
            </ul>
            <div class="row" id="knoppen">
                <div class="button move-cards-button">
                    <button onclick="moveCarousel(false);">Vorige kaarten</button>
                </div>
                <div class="button">
                    <button onclick="startGame()">Voltooi kernkwadrant</button>
                </div>
                <div class="button move-cards-button">
                    <button onclick="moveCarousel();">Volgende kaarten</button>
                </div>
            </div>
        </main>
        <?php include('../footer.php') ?>
	</body>
</html>
