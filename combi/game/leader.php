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
			
			// display current card value
			document.getElementById('nieuwe_kaart').innerText = game_info['current_card'];
			// fill the all_player_cards div with a table containing all cards of all players :)
			document.getElementById('all_player_cards').innerHTML = updateAllPlayerHands();
			document.getElementById('all_graveyard_cards').innerHTML = updateGraveyard();
        }
        
        function updateAllPlayerHands() {
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
			result += "</table>";

            return result;
		}
		
		function updateGraveyard() {
			var result = "<table><tr>";

			for (index in game_info['graveyard']) {
				var card = game_info['graveyard'][index];
				result += "<td>" + card + "</td>";
			}

			result += "</tr></table>";

			return result;
		}

		function endGame() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.location.href = '../../combi/end';
				}
			};
			xhttp.open("GET", "./api/end.php", true);
			xhttp.send();
		}

		function toggleGraveyard() {
			var element = document.getElementById('all_graveyard_cards');
			element.style.display = element.style.display == "none" ? "block" : "none";
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
				<h3>Spelers- en kaartenlijst</h3>
				<!-- this is in desperate need of some css to make it look nice! -->
				<div id="all_player_cards"></div>
				<h3>Aflegstapel</h3>
				<div id="all_graveyard_cards" style="display:none"></div>
				<div class="player-menu">
			<div class="button"><button onclick="endGame()">Spel beëindigen</button></div>
	        <!--<div class="button"><button onclick="undo()">Ongedaan maken</button></div> this is not a thing yet -->
			<div class="button"><button id="end_game_btn" onclick="toggleGraveyard()">Aflegstapel</button></div>
		</div>
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
