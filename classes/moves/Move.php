<?php

require_once(__DIR__.'/../../Game.php');

abstract class Move {
    public $source;
    public $name;
    public $mp;
    public $accuracy;

    public function __construct($source, $name, $mp, $accuracy = 100)
    {   
        $this->source = $source;
        $this->name = $name;
        $this->mp = $mp;
        $this->accuracy = $accuracy;
    }

    abstract public function execute($target);

    public function moveSuccess() {
        $rand = rand(1, 100);
        
        if($this->source->getMP() < $this->mp) {
            Game::log($this->source->getName() . ' used '. $this->name . ' but it has no MP');
            return false;
        }

        if($rand > $this->accuracy) {
            Game::log($this->source->getName() . ' used '. $this->name . ' but it missed');
            return false;
        }

        return true;
    }


    public function getCost() {
        return $this->mp;
    }
}