<?php

require_once('Pokemon.php');
require_once(__DIR__.'/../moves/Attack.php');
require_once(__DIR__.'/../moves/Buff.php');

class Pidgey extends Pokemon {

    public function __construct()
    {
        parent::__construct('Pidgey', 4, 100, 100, 'img/p1.gif', 'img/p2.png');
        $this->moves = [
            new Attack($this, 'Tackle', 0, 95, 0, 15, 20),
            new Attack($this, 'Brave Bird', 40, 90, 4, 50, 70, .1, 'RECOIL'),
            new Buff($this, 'Focus', 10, 95, .4, 'CRIT'),
            new Buff($this, 'Roost', 20, 100, 25, 'HP')
        ];
    }
}