<?php
if ((!isset($_GET['cards']) || !isset($_GET['email'])) || preg_match('/[^@]*@[^@]*\..{2,}/', $_GET['email']) == 0) {
	header('HTTP/1.1 400 Bad Request'); // non valid request
	exit();
}

$cards = explode(',', $_GET['cards']);

// message
$message = '
<html lang="nl=NL">
<head>
	<title>Uw kaarten</title>
</head>
<body>
	<h1>Uw kaarten van Kwaliteitenspel - Bewustwording</h1>
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

// recipients
$to = $_GET['email'];
$to = str_replace('\r', ' ', $to);
$to = str_replace('\n', ' ', $to);

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

// mail it
mail($to, $subject, $message, implode("\r\n", $headers));
?>
