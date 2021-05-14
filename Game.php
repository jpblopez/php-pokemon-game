<?php

require_once('./classes/pokemon/Bulbasaur.php');
require_once('./classes/pokemon/Charmander.php');
require_once('./classes/pokemon/Squirtle.php');
require_once('./classes/pokemon/Pidgey.php');

class Game
{

    public static function createPokemon($pokemon)
    {
        $res = null;

        if ($pokemon == 1) {
            $res = new Bulbasaur();
        } else if ($pokemon == 2) {
            $res = new Charmander();
        } else if ($pokemon == 3) {
            $res = new Squirtle();
        } else if ($pokemon == 4) {
            $res = new Pidgey();
        }

        return $res;
    }

    public static function createEnemy()
    {
        $rand = rand(1, 4);
        $res = Game::createPokemon($rand);
        $res->setName('Enemy');
        return $res;
    }

    public static function started()
    {
        return isset($_SESSION['started']);
    }

    public static function reset()
    {
        session_unset();
    }

    public static function over()
    {
        return isset($_SESSION['over']) && $_SESSION['over'] == true;
    }

    public static function startGame($pokemon)
    {
        $_SESSION['player'] = Game::createPokemon($pokemon);
        $_SESSION['choose_pokemon'] = $pokemon;
        $_SESSION['current_enemy'] = Game::createEnemy();
        $_SESSION['messages'] = [];
        $_SESSION['started'] = true;
        $_SESSION['over'] = false;
        $_SESSION['round'] = 1;
        $_SESSION['wins'] = 0;
        $_SESSION['loss'] = 0;
    }

    public static function log($message)
    {
        array_push($_SESSION['messages'], $message);
    }

    public static function getLog()
    {
        return $_SESSION['messages'];
    }

    public static function clearLog()
    {
        $_SESSION['messages'] = [];
    }
    public static function updateGameStatus()
    {

        $enemy = $_SESSION['current_enemy'];
        $player = $_SESSION['player'];

        if ($enemy->isDefeated() || $player->isDefeated()) {
            $win = $enemy->getHP() < $player->getHP() ? true: false;

            if($win) {
                $_SESSION['wins'] += 1;
                Game::log('Enemy has fainted. Player won the round');
            } else {
                $_SESSION['loss'] += 1;
                Game::log('Player has fainted. Enemy won the round');
                
            }

            $_SESSION['round'] += 1;
            $_SESSION['current_enemy'] = Game::createEnemy();
            $_SESSION['player'] = Game::createPokemon($_SESSION['choose_pokemon']);
        }

        if ($_SESSION['round'] > 5) $_SESSION['over'] = true;
    }

    public static function getPlayer()
    {
        return $_SESSION['player'];
    }

    public static function getEnemy()
    {
        return $_SESSION['current_enemy'];
    }

    public static function playerTurn($move)
    {
        $enemy = Game::getEnemy();
        $player = Game::getPlayer();

        $player->executeMove($move, $enemy);
    }

    public static function enemyTurn()
    {
        $enemy = Game::getEnemy();
        if($enemy->isDefeated()) return;

        $move = rand(0, 2);
        $player = Game::getPlayer();

        if ($enemy->getHP() < $enemy->getMaxHP() * .7) {
            $heal = rand(1, 100);

            if ($heal > 50) {
                $move = 3;
            }
        }

        if ($enemy->getMP() < $enemy->getMove($move)->getCost()) {
            $move = 0;
        }

        $enemy->executeMove($move, $player);
    }
}
