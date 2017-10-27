<?php
session_start();
if (isset($_POST['join_button'])) {
	if (strlen(str_replace(' ', '', $_POST['name'])) >= 3) {
		$code = strtoupper($_POST['code']);
		if (strlen($code) == 3) {
			$games_list = scandir("games");
			if (in_array($code.'.json', $games_list)) {
				$json = json_decode(file_get_contents("./games/$code.json"), true);
				if (!$json['game_started']) {
					$id = count($json['players']);
					if ($id > 10) {
						$error = 'lobby is vol';
					} else {
						$json['players'][] = array(
							'name' => $_POST['name'],
							'player_id' => $id,
						);
						$json['last_change'] = time();
						file_put_contents("./games/$code.json", json_encode($json));
						$_SESSION['player_id'] = $id;
						$_SESSION['game_id'] = $code;
						header('Location: lobby.php');
					}
				} else {
					$error = 'Je kan geen game joinen als die al bezig is.';
				}
			} else {
				$error = 'Verkeerde code of lobby bestaat niet';
			}
		} else {
			$error = 'Code moet 3 letters zijn.';
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
		<link rel="stylesheet" href="css/join_stylesheet.css" type="text/css">
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
				<div id="naamstyle">
					<label for="name">Vul je naam in:</label>
					 <input id="name"type="text" name="name">
				</div>
				<div id="groepstyle">
					<label for="code">Groepscode:</label>
					 <input id="code" type="text" name="code">
				</div>
				<input type="submit" value="Join" name="join_button">
			</form>
		</div>
	</body>
</html>
