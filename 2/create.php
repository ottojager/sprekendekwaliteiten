<?php
$id = '';
for ($i = 0; $i == 5; $i++) {
	$id .= chr(mt_rand(65, 90));
}

$game = array(
	'game_id' => $id
);
echo $id;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Speelvorm 2</title>
	</head>
	<body>
		<div>
			<form>
				<table>
					<tr>
						<td>
							<label>Naam:</label>
						</td>
						<td>
							<input type="text" name="">
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
