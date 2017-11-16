<?php
session_start();

// recipients
$to = $_GET['email']; // TODO: make players input their email at the start of the game and then use those here
$to = str_replace('\r', ' ', $to);
$to = str_replace('\n', ' ', $to);

// getting player cards
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), True);
$cards = $json['players'][ $_SESSION['player_id'] ]['stack'];

// message
$message = '
<html lang="nl=NL">
<head>
	<title>Uw kaarten</title>
</head>
<body>
	<h1>Uw kaarten van Kwaliteitenspel - Feedback</h1>
	<ul>';
	foreach ($cards as $key => $value) {
		if ($value != '') {
			$message .= '<li>'.$value.'</li>';
		}
	}
$message .= '</ul>
</body>
</html>';

// Preferences
$subject_preferences = array(
    "input-charset" => 'utf-8',
    "output-charset" => 'utf-8',
    "line-length" => 76,
    "line-break-chars" => "\r\n"
);


// Subject
$subject = 'Uw kaarten';

// who actually send the message
$headers[] = 'From: noreply@reacursist.nl';

// without these it won't be able to send html encoded emails
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=utf-8';

// required by some mail services
$headers[] = 'Content-Transfer-Encoding: 8bit';
$headers[] = 'Date: '.date('r (T)');
$headers[] = iconv_mime_encode('Subject', $subject, $subject_preferences);

// mail it!!!
mail($to, $subject, $message, implode("\r\n", $headers));
?>
