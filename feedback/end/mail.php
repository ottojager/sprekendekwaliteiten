<?php
session_start();

if (!isset($_SESSION['game_id'])) {
	header('HTTP/1.1 403 Forbidden');
}

// recipients
$to = $_POST['email']; // TODO: make players input their email at the start of the game and then use those here
echo $to;
$to = filter_var($to, FILTER_VALIDATE_EMAIL);
if (!$to) {
	header('HTTP/1.1 400 Bad Request');
	exit();
}
$to = str_replace('\r', ' ', $to);
$to = str_replace('\n', ' ', $to);

// getting player cards
$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../games/$game.json"), True);
$player = $json['players'][ $_SESSION['player_id'] ];
$cards = $player['stack'];

// message
$message = '
<html lang="nl">
<head>
	<title>Uw kaarten</title>
</head>
<body>
	<h1>Uw kaarten van Sprekende Kwaliteiten - Feedback</h1>
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

// who should recieve it
// $headers[] = 'To: '.$player['name'].'<'.$to.'>';

// Subject
$subject = 'Jouw resultaten van Sprekende Kwaliteiten - Feedback';

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
if (!mail($to, $subject, $message, implode("\r\n", $headers))) {
	header('HTTP/1.1 500 Internal Server Error');
}
?>
