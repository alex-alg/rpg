<?php
require __DIR__.'/vendor/autoload.php';

use Src\Game;

session_start();

$game = new Game();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$game->reset();
}

(!isset($_SESSION['game_in_progress']) || $_SESSION['game_in_progress'] === FALSE)
	? $game->init()
	: $game->turn();

if($game->shouldEndGame()){
	$game->getWinner();
}

include('src/views/main.php');
