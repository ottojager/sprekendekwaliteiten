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
	<title>Jouw kaarten</title>
	
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	
	<style type="text/css">
	
		body {
			margin:0;
		}

		h1 {
			color:#163143;
			font-family: Oswald, sans-serif;
		}
		
		.header-content {
			display: initial;
			height: 112px;
			margin: 0 0 0 auto;
    		/*float: right;*/
		}
		
		.header-content-title {
			width:100%;
			position:relative;
			top: 15px;
			left: 0%;
		}
		
		.titel {
			text-align:center;
			font-family: Oswald, sans-serif;
			text-transform: uppercase;
			letter-spacing: 1.0887244px;
			font-weight: 100;
			position: relative;
			z-index: 1;
			text-decoration: none;
			color: #264153;
		}
		
		.boven {
			font-size: 24px;
			margin-bottom: -4px;
			margin-top: -2px;
		}
		
		.onder	{
			font-weight: 100;
			margin-top: 0;
			letter-spacing: 0.3em;
			font-size: 26px;
			margin-bottom: 0px;
		}
		
		.header {
			border-bottom: 4px solid #163143;
			width:100%;
			margin:0;
			height:100px;	
			position: relative;
			background-color: white;
		}
		
		ul {list-style-type: none;}
		
		li.kaart {
			margin: 5px;
    		padding: 5px;
			height: 180px;
			width: 130px;
    		display: inline-block;
			vertical-align: middle;
			border-radius: 12px;
    		background: #d4263e;
		}
		
		div.kaartContainer {
    		background-color: #d4263e;
    		border: none;
		}
		
		li div p {
			margin-top: 50%;
			margin-bottom: 50%;
			color:white;
			text-align: center;
		}

		.footer {
			background-color: #e9e9ea;
			width: 100%;
			font-size: 10px;
			border-top: 4px solid #163143;
			position: fixed;
			bottom: 0;
			left: 0;
			height: 50px;
			box-sizing: border-box;
		}
			
		.footer p {
			color: #163143;
			padding: 10px 0;
			font-family: Oswald, sans-serif;
			font-size: 1.1vw;
			margin-bottom: 0px;
			margin-top: 0;
		}
			
		.credits {
			width: 100%;
			text-align: center;
		}
			
		.copyright {
			position: absolute;
			text-align: right;
			height: 25px;
			bottom: 0;
			right: 4%;
		}
	
	</style>
	
</head>
<body>

<div class="header">
<div class="header-content">
		<div class="header-content-title">
			<h1 class="titel boven">sprekende</h1>
			<h1 class="titel onder">kwaliteiten</h1>
		</div>
	</div>
</div>

	<h1>Jouw kaarten van Kwaliteitenspel - Bewustwording</h1>
	<ul>';
	foreach ($cards as $key => $value) {
		if ($value != '') {
			$message .= '<li class="kaart"><div class="kaartContainer"><p>'.$value.'</p></div></li>';
		}
	}
$message .= '</ul>

<div class="footer">
	<p class="credits">Sprekende kwaliteiten is uitgevoerd met toestemming van Peter Gerrickens en mogelijk gemaakt door Stichting Bartimeus Sonneheerdt en het KF Heinfonds</p><p class="copyright">©Eye4Web 2017-2018</p>
</div>


</body>
</html>

';


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
$subject = 'Jouw resultaten van Sprekende Kwaliteiten - Bewustwording ';

// who actually send the message
$headers[] = 'From: sprekendekwaliteiten@eye4web.nl';

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
