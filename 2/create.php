<?php
session_start();
if (isset($_POST['makeLobbyButton'])) {
	if (strlen($_POST['name']) >= 3) {
		// generate game id
		$id = '';
		for ($i = 0; $i != 5; $i++) {
			$id .= chr(mt_rand(65, 90)); // random uppercase ASCII character
		}

		$game = array(
			'game_id' => $id,
			'leader_name' => $_POST['name'],
			'players' => array(),
			'game_started' => false;
		);

		$json = json_encode($game);
		file_put_contents("./games/$id.json", $json);

		$_SESSION['game'] = $id;
		header('Location: lobby.php');
	} else {
		$error = 'Naam moet minimaal 3 characters bevaten.';
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Speelvorm 2</title>
	</head>
	<body>
		<div>
			<?php
			if (isset($error)) {
				echo "<p>$error</p>";
			}
			?>
			<form method="post">
				<table>
					<tr>
						<td>
							<label>Naam:</label>
						</td>
						<td>
							<input type="text" name="name">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="Maak Lobby" name="makeLobbyButton">
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
