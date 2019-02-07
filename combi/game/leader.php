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
			updateAllPlayerHands();
			//document.getElementById('all_graveyard_cards').innerHTML = updateGraveyard();
		}
		
		function undoLastMove() {
			var xhttp = new XMLHttpRequest();
			xhttp.open("GET", "./api/undo.php", true);
			xhttp.send();
			start_update();
		}
        
        function updateAllPlayerHands() {
			var buttons = document.getElementsByClassName("player-button");
            for (index in game_info['players']) {
				var player = game_info['players'][index];
				var playerDataBox = document.getElementById("player_cards_" + index);
				var dataBoxName = playerDataBox.getElementsByTagName("h3")[0];
				var dataBoxCardList = playerDataBox.getElementsByTagName("ul")[0];

				dataBoxName.innerHTML = '';
				dataBoxCardList.innerHTML = '';
				dataBoxName.innerHTML = player["name"];

				buttons[index].getElementsByTagName("button")[0].innerHTML = player["name"] + " (" + player["stack"].length + ")";

                for (card_index in player['stack']) {
					var li = document.createElement('li');
					li.innerHTML = player['stack'][card_index];
                    dataBoxCardList.appendChild(li);
                }
			}
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
					// not redirecting to end page anymore because leader already has a nice overview of all players and their cards on this page!
					// instead, we just turn the "current player indicator" into a "game has ended indicator"
					document.getElementById('current_player_indicator').innerText = "Het spel is beëindigd!";
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
				<?php
				$playerCardLists = "";
				foreach ($json['players'] as $key => $value) {
					if ($value['name'] != 'Afval stapel') {
						//<div class="player-button"><button>'.$value['name'].' ('.count($value['stack']).')</button></div>
						echo('<div class="player-button" onclick="toggleCardView('.$key.')"><button>'.$value['name'].' ('.count($value['stack']).')</button></div>');
						$playerCardLists .= "<div id=\"player_cards_$key\" class=\"player_cards\" style=\"display:none\"><h3>".$value['name']."</h3><ul></ul></div>";
					}
				}
				echo($playerCardLists);
		    	?>
				<h3>Aflegstapel</h3>
				<div id="all_graveyard_cards" style="display:none"></div>
				<div class="player-menu">
			<div class="button"><button onclick="endGame()">Spel beëindigen</button></div>
	        <div class="button"><button onclick="undoLastMove()">Ongedaan maken</button></div>
			<div class="button"><button onclick="toggleGraveyard()">Aflegstapel</button></div>
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
