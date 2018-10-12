<?php
session_set_cookie_params(24*60*60); // change how long session cookies last
                                     // the arg is the number of seconds the cookie lasts
session_start();
if (isset($_POST['makeLobbyButton'])) {
	$name = trim($_POST['name']);
	if (strlen($name) >= 2 && strlen($name) <= 10) {
		if ((int)$_POST['cards'] <= 70 && (int)$_POST['cards'] > 0) { // if the assigned amount of cards is less than 70
			                                                          // TODO: add a propper minimum amount of cards
			//list of filtered codes
			$filtered_names = array (
				'LUL','KUT','PIK','SEX','FUC','FUK','SUC','KKK','GAY','FAG','NIG','ZAK','POO','PIS','DIK','KOK','COK',
				'ASS','TIT','JIZ','CUM','GOY','STD','NAZ','NZI','HEL','GUN','BOM','PRN','WWI','JAP','NIP','NAP','WAR',
				'WII','HIV','SOA','HIS','HER','DWN','MOF','CBT','XXX',
			);

			// generate game id
			do {
				$id = '';
				for ($i = 0; $i != 3; $i++) {
					$id .= chr(mt_rand(65, 90)); // random uppercase ASCII character
					                             // 65 = A
												 // 90 = Z
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
			$_SESSION['game_mode'] = 2;
			$_SESSION['player_name'] = $name;
			header('Location: ./lobby.php');
		} else {
			$error = 'Kaarten moet een getal tussen 0 en 70 zijn.';
		}
	} else {
		$error = 'Naam moet minimaal 2 tekens en mag maximaal 10 bevatten.';
	}
	$name = $_POST['name'];
} else {
	$name = '';
}
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<script>
		function validate_form() {
			var name = document.getElementById('name').value;
			var error = document.getElementById('error');
			error.innerHTML = ''; // remove any left over error messages

			name = name.trim(); // remove white space at beggining and end of the string

			if (name.length >= 3) {
				return true;
			} else {
				error.innerHTML = 'Je naam moet minimaal 3 characters lang zijn.';
			}
			return false;
		}
		</script>
		<title>Aanmaken spel - Feedback - Sprekende Kwaliteiten</title>
		<link rel="stylesheet" href="../css/basis.css" type="text/css">
		<link rel="stylesheet" href="../css/spelvorm2.css" type="text/css">
		<link rel="stylesheet" href="../css/header.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="stylesheet" href="../css/Feedback_background.css"type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
		<meta charset="utf-8">
	</head>
	<body>
		<span class="alienBackLeft"></span>
		<span class="alienBackRight"></span>
		<ul class="skip-link">
			<li><a href="#main">Skip naar main content</a></li>
		</ul>
		<?php
		// create some variables to add header values
		$spelvorm = 'Feedback';

		include('../header.php');
		?>
		<main class="container" id="main">
			<div id="title"><h2>Aanmaken spel - Feedback</h2>
			<p>Als spelleider maak je hier een nieuw spel "Feedback" aan. Vul je naam in en kies het aantal kaarten waarmee je de groep wilt laten spelen (maximaal 70).</p></div>
			<form onsubmit="return validate_form()" method="post">
				<p id="error"><?php if (isset($error)) { echo $error; } ?></p>
				<div class="red_border">
					<div class="formfield">
						<label for="name">Naam:</label><input id="name" type="text" name="name" value="<?php echo $name ?>">
					</div>
				</div>
				<div class="red_border" >
					<div class="formfield">
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
				<div class="button">
					<button type="submit" value="Aanmaken spel" name="makeLobbyButton"> Aanmaken spel
    				</button>
				</div>
			</form>
		</main>
		<?php include('../footer.php') ?>
	</body>
</html>
