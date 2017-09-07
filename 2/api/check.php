<?php
session_start();
$game = $_SESSION['game'];
$json = file_get_contents("../games/$game.json");
echo $json;
?>
