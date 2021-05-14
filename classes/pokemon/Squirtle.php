<?php

require_once('Pokemon.php');
require_once(__DIR__.'/../moves/Attack.php');
require_once(__DIR__.'/../moves/Buff.php');

class Squirtle extends Pokemon {

    public function __construct()
    {
        parent::__construct('Squirtle', '3', 110, 110, 'img/s1.gif', 'img/s2.png');
        $this->moves = [
            new Attack($this, 'Tackle', 0, 95, 0, 15, 20),
            new Attack($this, 'Water Gun', 20, 90, 3, 15, 25),
            new Attack($this, 'Hydro Cannon', 40, 80, 3, 30, 50, .2),
            new Buff($this, 'Heal', 30, 100, 30, 'HP'),
        ];
    }
}