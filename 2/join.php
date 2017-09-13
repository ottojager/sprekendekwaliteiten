<?php
	session_start();
	if (isset($_POST['join_button'])) {
		if (strlen($_POST['name']) >= 3) {
			$code = $_POST['code'];
			if (strlen($code) == 5) {
				$games_list = scandir("games");
				if (in_array($code.'.json', $games_list)) {
					$json = json_decode(file_get_contents("./games/$code.json"), true);

					$id = count($json['players']);
					if ($id > 8) {
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
					echo 'verkeerde code of lobby bestaat niet';
				}
			} else {
				$error = 'code moet vijf cijfers zijn.';
			}
		} else {
			$error = 'niet lang genoeg?!';
		}
	}
?>


<!DOCTYPE html>
<html lang="nl=NL">
	<head>
		<title>Speelvorm 2</title>
        <link rel="stylesheet" href="join_stylesheet.css" type="text/css">
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
                    <label>Vul je naam:</label>
                    <input type="text" name="name">
                </div>
                <div id="groepstyle">
                    <label>Groepscode:</label>
                    <input type="text" name="code">
                </div>
                <input type="submit" value="Join" name="join_button">
            </form>
		</div>
	</body>
</html>
