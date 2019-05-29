<?php
require('../mail/MailBuilder.php');
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
$player = $json['players'][$_SESSION['player_id']];
$cards = $player['stack'];

$builder = new MailBuilder();
$builder->setTitle("Combi");
$builder->insertCards(array_values($cards));
$builder->sendMail($to);