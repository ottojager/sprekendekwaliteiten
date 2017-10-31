<?php
session_start();
if (isset($_POST['makeLobbyButton'])) {
	if (strlen(str_replace(' ', '', $_POST['name'])) >= 3) {
		if ((int)$_POST['cards'] <= 70 && (int)$_POST['cards'] > 0) { // if the assigned amount of cards is less than 70
			                                                          // TODO: add a propper minimum amount of cards
			//list of filtered codes
			$filtered_names = array (
				'LUL','KUT','PIK','SEX','FUC','FUK','SUC','KKK','GAY','FAG','NIG','ZAK','POO','PIS','DIK','KOK','COK',
				'ASS','TIT','JIZ','CUM','GOY','STD','NAZ','NZI','HEL','GUN','BOM','PRN','WWI','JAP','NIP','NAP','WAR',
				'WII','HIV','SOA','HIS','HER','DWN','MOF','CBT',
			);
			// generate game id
			do {
				$id = '';
				for ($i = 0; $i != 3; $i++) {
					$id .= chr(mt_rand(65, 90)); // random uppercase ASCII character
				}
			} while (in_array($id,$filtered_names));

			$game = array(
				'game_id' => $id,
				'leader_name' => $_POST['name'],
				'players' => array(),
				'game_started' => false,
				'max_cards' => (int)$_POST['cards'],
				'turn_action' => array(),
			);

			file_put_contents("./games/$id.json", json_encode($game));

			$_SESSION['player_id'] = 11;
			$_SESSION['game_id'] = $id;
			header('Location: lobby.php');
		} else {
			$error = 'Kaarten moet een getal tussen 0 en 70 zijn';
		}
	} else {
		$error = 'Naam moet minimaal 3 letters bevaten.';
	}
}
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Speelvorm 2</title>
		<link rel="stylesheet" href="css/cr_stylesheet.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<div>
<?php
			if (isset($error)) {
				echo "<p>$error</p>";
			}
			?>
			<form method="post">
				<h1>Kwaliteitenspel</h1>
				<div id="formstyle">
					<label>Naam:</label>
					<input type="text" name="name">
				</div>
				<div id="cardstyle">
					<label>Aantal kaarten:</label>
					<input type="number" name="cards" min="0" max="70" value="70">
				</div>
					<input type="submit" value="Maak Lobby" name="makeLobbyButton">
			</form>
		</div>
	</body>
</html>
