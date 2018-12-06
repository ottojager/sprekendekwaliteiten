<!DOCTYPE html>
<html lang="nl">
	<head>
		<script src="./api/js/std.js" defer></script>
		<script>
		var amount_players = <?php echo count($json['players']);?>;
        var own_id = <?php echo $_SESSION['player_id'];?>;
        
        function update_page_view() {
			// this funtion implements page updating
			// it will be called by update_view() in std.js everytime the game's
			// json file is updated

			// check if it's that players turn and redirect them to the current
			// player version of the page
			if (game_info['current_player'] == own_id) {
				window.location = './';
			}

			// update page content
			document.getElementById('current_player_indicator').innerText =
            game_info['players'][game_info['current_player']]['name']+" is aan de beurt...";
            
            document.getElementById('nieuwe_kaart').innerText = game_info['current_card'];
            document.getElementById('all_player_cards').innerHTML = displayAllPlayerHands();
        }
        
        function displayAllPlayerHands() {
            var result = "<table>";
            
            // looping through all cards in hand and stack and putting them into a html table :_)
            for (index in game_info['players']) {
                var player = game_info['players'][index];
                result += "<tr><td><b>" + player['name'] + "</b></td><td><table><tr><td><b>In hand</b></td>";
                for (card_index in player['hand']) {
                    var card = player['hand'][card_index];
                    result += "<td>" + card + "</td>";
                }
                result += "</tr><tr><td><b>Ontvangen</b></td>";
                for (card_index in player['stack']) {
                    var card = player['stack'][card_index];
                    result += "<td>" + card + "</td>";
                }
                result += "</tr></table></td></tr>";
            }

            return result;
        }
		</script>
		<meta charset="utf-8">
		<title>Actief - Combi - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="../../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../../css/header.css" type="text/css">
		<link rel="stylesheet" href="../../css/footer.css" type="text/css">
		<link rel="stylesheet" href="../../css/spelvorm3.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="../css/Rainbow_placeholder.png">
	</head>
	<body>
		<a href="#main" class="skip-link">Skip naar main content</a>
		<?php
		include('../../header.php');
		?>
		<main class="container" id="main" tabindex="-1">
			<div class="linker-menu">
				<h2>Nieuwe kaart</h2>
				<div class="eind-kaart">
					<button id="nieuwe_kaart"><?php echo $json['current_card']; ?></button>
				</div>
			</div>

			<h2 id="current_player_indicator"><?php echo $json['players'][$json['current_player']]['name'];?> is aan de beurt...</h2>
			<ul class="trade-rij">
                <div id="all_player_cards"></div>
			</ul>
		</main>
		<?php include('../../footer.php') ?>
	</body>
</html>
<?php
// adding listeners
if ($_SESSION['player_id'] == 11) {
?>
<script>
// leader_card(amount_players);
</script>
<?php } ?>
