<?php
session_start();
$game = $_SESSION['game_id'];
$json = file_get_contents("../games/$game.json");
echo $json;
?>
