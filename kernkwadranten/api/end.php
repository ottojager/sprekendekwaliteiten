<?php
require('../../functions.php'); //Get useful functions
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['logged_in']) {
    $_SESSION['kernkwadrant_results'] = json_decode(file_get_contents('php://input'), true);
    echo(json_encode(["success"=>true]));
    header("Content-Type: application/json");
}