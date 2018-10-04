<!DOCTYPE html>
<html lang="nl=NL">
<head>
	<title>Einde - Feedback - Sprekende Kwaliteiten</title>
	<link rel="stylesheet" href="../css/end.css" type="text/css">
	<link rel="icon" sizes="16x16" type="image/png" href="/../kwal-spel/feedback/css/Rainbow_placeholder.png">
	<script src="./mail.js"></script>
</head>
<body>
	<div id="topbar"></div>
	<div id="sidetopbar">
		<div id="borderimage"></div>
		<div id="player__name"><?php echo $json['players'][ $_SESSION['player_id'] ]['name'];?></div>
	</div>
	<div id="container">
		<h1>Einde spel - Feedback</h1>
		<p id="uitlegtekst">Vul hier je email adres in, zodat je kaarten naar jou opgestuurd kunnen worden.</p>
		<label for="email">Email</label>
		<input name="mail" type="email" id="email" />
		<button id="sendmail" onclick="send_mail()">Mail mijn kaarten</button>
	</div>
</body>
</html>
