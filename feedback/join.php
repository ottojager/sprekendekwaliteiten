<?php
session_set_cookie_params(24*60*60); // change how long session cookies last
                                     // the arg is the number of seconds the cookie lasts
session_start();
if (isset($_POST['join_button'])) {
	$name = trim($_POST['name']);
	if (strlen($name) >= 3) {
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
		$error = 'Naam moet minimaal 3 characters bevaten.';
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
		function validate() {
			var name = document.getElementById('name').value;
			var code = document.getElementById('code').value;


		}
		</script>
		<title>Doe mee - Feedback - Kwaliteitenspel</title>
		<link rel="stylesheet" href="css/join_stylesheet.css" type="text/css">
		<link rel="icon" sizes="16x16" type="image/png" href="css/Rainbow_placeholder.png">
		<?php
		if (isset($error)) {
			echo "<script>alert('$error');</script>";
		}
		?>
	</head>
	<body>
		<div>
			<form method="post">
				<h1>Kwaliteitenspel</h1>
				<div id="naamstyle">
					<label for="name">Vul je naam in:</label>
					<input id="name"type="text" name="name" value="<?php echo $name ?>">
				</div>
				<div id="groepstyle">
					<label for="code">Groepscode:</label>
					<input id="code" type="text" name="code" value="<?php echo $code ?>">
				</div>
				<button onclick="validate">Doe mee</button>
				<input name="join_button" value="Doe mee" type="submit" />
			</form>
		</div>
	</body>
</html>
