<?php

require_once('Pokemon.php');
require_once(__DIR__.'/../moves/Attack.php');
require_once(__DIR__.'/../moves/Buff.php');

class Bulbasaur extends Pokemon {

    public function __construct()
    {
        parent::__construct('Bulbasaur', '1', 100, 110, 'img/b1.gif', 'img/b2.png');
        $this->moves = [
            new Attack($this, 'Tackle', 0, 95, 0, 10, 20),
            new Attack($this, 'Vine Whip', 20, 90, 1, 25, 40),
            new Attack($this, 'Leech Seed', 30, 85, 0, 25, 25, 0, 'HPGAIN'),
            new Buff($this, 'Photosynthesis', 30, 100, 40, 'HP'),
        ];
    }
}