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
            var kwaliteiten = <?= json_decode($_SESSION["kernkwadrant_results"]) ?>;
        </script>
		<title>Overzicht - Kernkwadranten - Sprekende Kwaliteiten</title>
		<meta charset="utf-8">
	</head>
	
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
        $spelvorm = 'Kernkwadranten';
        $counter = 0;

		require('../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
            <h1>Overzicht: jouw kernkwadranten</h1>
            <div style="display:flex;justify-content:center;align-items:center;">
                <p>Hieronder vind je alle kernkwadranten die je zojuist hebt gemaakt.</p>
            </div>
            <br/>
            <?php foreach($_SESSION["kernkwadrant_results"] as $key=>$value): $counter++; ?>
                <h2>Kernkwadrant bij '<?=$key?>'</h2>
                <ul>
                <div class="kaart-rij">
                <li class="kwadrant-kaart-box"><h3>Kernkwaliteit</h3><div><p><?=$key?></p></div></li>
                <span class="kwadrant-arrow">→</span>
                <li class="kwadrant-kaart-box"><h3>Valkuil</h3><div><p><?=$value["valkuil"]?></p></div></li>
                <br/>
                <div class="kwadrant-arrow-vertical">↑</div>
                <div class="kwadrant-arrow-vertical">↓</div>    
            </div>
                <div class="kaart-rij">
                <li class="kwadrant-kaart-box"><h3>Allergie</h3><div><p><?=$value["allergie"]?></p></div></li>
                <span class="kwadrant-arrow">←</span>
                <li class="kwadrant-kaart-box"><h3>Uitdaging</h3><div><p><?=$value["uitdaging"]?></p></div></li>
                </div>
            </ul>
            <hr/>
            <?php endforeach; ?>
            <div class="bottom-menu">
	            <div class="button"><button onclick="confirmCardSelections()">Stuur mijn kwaliteiten</button></div>
	            <div class="button"><button class="back-button" onclick="window.location='../index.php'">Terug naar Home</button></div>
            </div>
        </main>
		<?php include('../footer.php') ?>
	</body>
</html>

<!-- TODO: Add mail stuff next time :) -->