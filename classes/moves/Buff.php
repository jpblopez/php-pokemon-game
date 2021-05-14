<?php

require_once('Move.php');
require_once('Attack.php');

class Buff extends Move
{
    public $value;
    public $buff;

    public function __construct($source, $name, $mp, $accuracy, $value, $buffType)
    {
        parent::__construct($source, $name, $mp, $accuracy);
        $this->value = $value;
        $this->buff = $buffType;
    }

    public function execute($target = null)
    {

        $valid = $this->moveSuccess();

        if (!$valid) {
            $this->source->reduceMP($this->mp);
            return;
        }
        $this->source->reduceMP($this->mp);


        if ($this->buff == 'HP') {
            $this->source->addHP($this->value);
            Game::log($this->source->getName() . " restored " . $this->value . " HP");
        } else if ($this->buff == 'CRIT') {

            $moves = $this->source->getMoves();

            foreach ($moves as $a) {
                if ($a instanceof Attack) {
                    $a->addCrit($this->value);
                }
            }
            Game::log($this->source->getName() . " is focusing");
        }
    }
}
