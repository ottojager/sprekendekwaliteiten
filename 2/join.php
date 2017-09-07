<?php
	session_start();
	if (isset($_POST['join_button'])) {
		if (strlen($_POST['name']) >= 3) {
			if (strlen($_POST['code']) == 5) {
				//code to get unique ID and go to lobby
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
