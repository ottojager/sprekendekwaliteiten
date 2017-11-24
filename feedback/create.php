<?php
session_set_cookie_params(24*60*60); // change how long session cookies last
                                     // the arg is the number of seconds the cookie lasts
session_start();
if (isset($_POST['makeLobbyButton'])) {
	$name = trim($_POST['name']);
	if (strlen($name) >= 3) {
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
				'leader_name' => $name,
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
			$error = 'Kaarten moet een getal tussen 0 en 70 zijn.';
		}
	} else {
		$error = 'Naam moet minimaal 3 characters bevaten.';
	}
	$name = $_POST['name'];
} else {
	$name = '';
}
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Aanmaken spel - Feedback - Kwaliteitenspel</title>
		<link rel="stylesheet" href="css/cr_stylesheet.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
		<meta charset="utf-8">
		<?php
		if (isset($error)) {
			echo "<script>alert('$error');</script>";
		}
		?>
	</head>
	<body>
		<div>
			<div id="topbar"></div>
			<div id="help">
				<div id="borderimage"></div>
				<div id="player__name"></div>
			</div>
			<form method="post">
				<div id="title"><h1>Kwaliteitenspel</h1></div>
				<div id="inveld">
					<div class="inputstyle">
						<label for="name">Naam:</label>
						<input id="name" type="text" name="name" value="<?php echo $name ?>">
					</div>
				</div>
				<div id="no_ones_gonna_look_trough_this_code_anyway" >
					<div class="cardstyle">
						<label for="cards">Aantal kaarten:</label>
						<select name="cards">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="50">50</option>
							<option value="60">60</option>
							<option selected value="70">70</option>
						</select>
					</div>
				</div>
				<input type="submit" value="Aanmaken spel" name="makeLobbyButton">
			</form>
		</div>
	</body>
</html>