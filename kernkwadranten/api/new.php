<?php
require('../../functions.php'); //Get useful functions
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Check if POST and logged in
    $receivedCards = json_decode(file_get_contents('php://input')); //Extract cards received in a previous game from the POST body
    $existingCards = getAllCards(CardOptions::Kwaliteiten); //Get all kwaliteiten cards from database
    $_SESSION['kernkwadrant_results'] = []; //Make new array in session
    $_SESSION['kernkwadrant_selected'] = false;
    
    foreach ($receivedCards as $card) { //Loop through all received cards
        if (getCardType($existingCards, $card)) { //Check if received card exists (which would mean it's a kwaliteit rather than a valkuil)
            $_SESSION['kernkwadrant_results'][$card] = ['valkuil' => null,
            'allergie' => null, 
            'uitdaging' => null]; //Add card to session variable (and give it some properties that will later have to be filled)
        }
    }

    echo(json_encode(["success"=>true]));
    header("Content-Type: application/json");
}
