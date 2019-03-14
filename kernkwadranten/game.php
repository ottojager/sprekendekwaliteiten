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
            var ids = {0: "kernkwaliteitCard", 1: "valkuilCard", 2: "uitdagingCard", 3: "allergieCard"};
            var currentKernkwaliteitIndex = 0;
            var carouselIndex = 0;
            
            var counter = 0;
            for (var key in playerKwaliteiten) {
                indices[counter] = key;
                counter++;
            }

            window.addEventListener('load', function() {
                startGame();
            });
        </script>
        <script src="./js/scripts.js" type="text/javascript" defer></script>
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
            <h2><b>[kwadrant]: </b>[vraagstelling]</h2>
            <ul>
                <div class="kaart-rij">
                    <?php 
                        for ($i = 0; $i < 5; $i++) {
                            echo '<li class="kaart"><button><p class="carousel-card-text"></p></button></li>';
                        }
                    ?>
                </div>
            </ul>
        </main>
        <?php include('../footer.php') ?>
	</body>
</html>
