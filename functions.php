<?php

function getAllCards($cardOptions) {
    $config = json_decode(file_get_contents(__DIR__.'/.env.json'), true); // load the db connection info
    $db = mysqli_connect($config['hostname'], $config['username'], $config['password']);

    mysqli_select_db($db, $config['database']);
    $sql = "SELECT * FROM cards";
    if ($cardOptions != CardOptions::Both) {
        $sql .= " WHERE type = $cardOptions";
    }
    mysqli_query($db, "SET NAMES 'utf8'");
    $result = mysqli_query($db, $sql);
    $array = array();
    while ($card = mysqli_fetch_assoc($result)) {
        $array[] = ["name" => $card['name'], "type" => $card['type']];
    }

    return $array;
}

function getCardType($cardArray, $cardName) {
    foreach ($cardArray as $card) {
        if ($card['name'] == $cardName) {
            return $card['type'];
        }
    }
    return false; //Card doesn't exist
}

abstract class CardOptions { //That's as close to an enum I could find
    const Kwaliteiten = 1;
    const Valkuilen = 2;
    const Both = 3;
}