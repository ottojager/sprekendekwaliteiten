<!DOCTYPE html>
<?php
$db = mysqli_connect('localhost', 'root');
mysqli_select_db($db, "kwaliteitenspel");
$sql = "SELECT * FROM cards";
$result = mysqli_query($db, $sql);
$cardstack = array();
while ($card = mysqli_fetch_assoc($result)) {
    $cardstack[] = $card['name'];
}
?>
<html>
	<head>
		<title>Speelvorm 2</title>
		<script src="api/js/std.js"></script>
	</head>
	<body>
		<p>
			in een game!
		</p>
	</body>
</html>
