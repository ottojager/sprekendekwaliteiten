<?php
session_start();

if (!$_SESSION['logged_in']) { return; }

if (!$_SESSION['kernkwadrant_selected']) {
    $selectedCards = json_decode(file_get_contents('php://input'));
    $cards = $_SESSION['kernkwadrant_results'];
    $keys = array_keys($cards);

    foreach ($keys as $key) {
        if (!in_array($key, $selectedCards)) {
            unset($_SESSION['kernkwadrant_results'][$key]);
        }
    }

    echo(json_encode(["success"=>true]));
    header("Content-Type: application/json");
}