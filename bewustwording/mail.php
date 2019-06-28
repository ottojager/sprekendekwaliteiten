<?php
require('../mail/MailBuilder.php');
if ((!isset($_GET['cards']) || !isset($_GET['email'])) || preg_match('/[^@]*@[^@]*\..{2,}/', $_GET['email']) == 0) {
	header('HTTP/1.1 400 Bad Request'); // non valid request
	exit();
}

$cards = explode(',', $_GET['cards']);

$builder = new MailBuilder();
$builder->setTitle("Bewustwording");
$builder->insertCards($cards);
echo($builder->sendMail($_GET['email']));
?>
