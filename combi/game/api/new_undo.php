<?php
session_start();

if ($_SESSION['player_id'] != 11 || !isset($_SESSION['game_id'])) return; //exit function if no game active or not leader

$game = $_SESSION['game_id'];
$json = json_decode(file_get_contents("../../games/$game.json"), true);
//Get index of the player who had the previous turn
$last_player = ($json['current_player'] == 0 ? sizeof($json['players']) : $json['current_player']) -1;

//first of all, add the current card back to the card stack
array_unshift($json['card_stack'], $json['current_card']);

//check if move type is swap
if ($json['last_move_type'] == 's') {
    //get value of the last played card (this is set in game_logic)
    $last_card = $json['last_played_card'];
    echo($last_card);
    //get index of the last played card so we know where to put the old card back (this is also set in game_logic)
    $last_index = $json['last_swapped_index'];
    echo($last_index);
    //get (and remove) the last card in the graveyard (this is the card that was discarded by a swap)
    $last_graveyard_card = array_pop($json['graveyard']);
    echo($last_graveyard_card);

    //put the current card back to the card that was originally added to the player's hand
    $json['current_card'] = $last_card;
    //put the discarded (so from graveyard) card back into the player's hand
    $json['players'][$last_player]['hand'][$last_index] = $last_graveyard_card;    
}

//give the turn to the previous player
$json['current_player'] = $last_player;
//save timestamp
$json['last_change'] = time();

//finally, save the json
file_put_contents("../../games/$game.json", json_encode($json));