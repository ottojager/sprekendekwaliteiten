<?php
session_set_cookie_params(24*60*60); // change how long session cookies last
                                     // the arg is the number of seconds the cookie lasts
session_start();
if (isset($_POST['join_button'])) {
	$name = trim($_POST['name']);
	if (strlen($name) >= 2 && strlen($name) <= 20) {
		if ($name != 'Afval stapel') {
			$code = strtoupper($_POST['code']);
			if (strlen($code) == 3) {
				$games_list = scandir("games");
				if (in_array($code.'.json', $games_list)) {
					$json = json_decode(file_get_contents("./games/$code.json"), true);
					if (!$json['game_started']) {
						$id = count($json['players']);
						if ($id > 10) {
							$error = 'Spel is vol.';
						} else {
							$json['players'][] = array(
								'name' => $name,
								'player_id' => $id,
							);
							$json['last_change'] = time();
							file_put_contents("./games/$code.json", json_encode($json));
							$_SESSION['player_id'] = $id;
							$_SESSION['player_name'] = $name; // because player_id might need to change later
							$_SESSION['game_id'] = $code;
							header('Location: lobby.php');
						}
					} else {
						$error = 'Je kan niet mee doen aan een spel als deze al bezig is.';
					}
				} else {
					$error = 'Verkeerde code of spel bestaat niet.';
				}
			} else {
				$error = 'Code moet 3 letters zijn.';
			}
		} else {
			$error = 'Die naam is gereseveert.';
		}
	} else {
		$error = 'Naam moet minimaal 3 tekens en mag maximaal 20 bevatten.';
	}
	$name = $_POST['name'];
	$code = $_POST['code'];
} else {
	$name = '';
	$code = '';
}
?>
<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<script>
		function validate_form() {
			var name = document.getElementById('name').value;
			var code = document.getElementById('code').value;
			var error = document.getElementById('error');
			error.innerHTML = ''; // remove any left over error messages

			name = name.trim(); // remove white space at beggining and end of the string

			if (name.length >= 3) {
				if (code.length == 3) {
					return true;
				} else {
					error.innerHTML = 'De code moet precies 3 letters zijn.';
				}
			} else {
				error.innerHTML = 'Je naam moet minimaal 3 tekens lang zijn.';
			}
			return false;
		}
		</script>
		<meta charset="utf-8">
		<title>Doe mee - Combi - Kwaliteitenspel</title>
		<link rel="stylesheet" href="css/join_stylesheet.css" type="text/css">
		<link rel="stylesheet" href="../css/footer.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
	</head>
	<body>
		<div id="topbar"></div>
		<div id="sidetopbar">
			<div id="borderimage"></div>
			<div id="player__name"></div>
		</div>
		<div id="container">
			<h1>Kwaliteitenspel - Feedback</h1>
			<p>Vul je naam in. De groepscode krijg je van je spelleider.</p>
			<form onsubmit="return validate_form()" method="post">
				<p id="error"><?php if (isset($error)) { echo $error; } ?></p>
				<div class="red_border">
					<div class="formfield">
						<label for="name">Vul je naam in:</label>
						<input id="name"type="text" name="name" value="<?php echo $name ?>">
					</div>
				</div>
				<div class="red_border">
					<div class="formfield">
						<label for="code">Groepscode:</label>
						<input id="code" type="text" name="code" value="<?php echo $code ?>">
					</div>
				</div>
				<input name="join_button" value="Doe mee" type="submit" />
			</form>
		</div>
		<?php include('../footer.php') ?>
	</body>
</html>