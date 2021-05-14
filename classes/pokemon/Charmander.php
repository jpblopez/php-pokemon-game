<?php

require_once('Pokemon.php');
require_once(__DIR__.'/../moves/Attack.php');
require_once(__DIR__.'/../moves/Buff.php');

class Charmander extends Pokemon {

    public function __construct()
    {
        parent::__construct('Charmander', '2', 120, 80, 'img/c1.gif', 'img/c2.png');
        $this->moves = [
            new Attack($this, 'Tackle', 0, 95, 0, 15, 25),
            new Attack($this, 'Flamethrower', 20, 90, 2, 10, 25),
            new Attack($this, 'Fire Fang', 25, 90, 2, 30, 40, .15),
            new Buff($this, 'Heal', 30, 100, 30, 'HP'),
        ];
    }
}