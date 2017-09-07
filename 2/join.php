<?php
	session_start();
	if (isset($_POST['join_button'])) {
		if (strlen($_POST['name']) >= 3) {
			$code = $_POST['code'];
			if (strlen($code) == 5) {
				$games_list = scandir("games");
				if (in_array($code.'.json', $games_list)) {
					$json = json_decode(file_get_contents("./games/$code.json"), true);

					$id = count($json['players']) + 1;
					$json['players'][] = array(
						'name' => $_POST['name'],
						'playerID' => $id,
					);
					file_put_contents("./games/$code.json", json_encode($json));

					$_SESSION['playerID'] = $id;
					$_SESSION['game'] = $code;
					header('Location: lobby.php');
				}
				else {
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
						<td>
							<label>code:</label>
						</td>
						<td>
							<input type="text" name="code">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="join" name="join_button">
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
