<?php

require_once('Move.php');
require_once(__DIR__ . '/../../Game.php');

class Attack extends Move
{
    public $type;
    public $minDamage;
    public $maxDamage;
    public $crit;

    public function __construct($source, $name, $mp, $accuracy, $type, $min, $max, $crit = .05, $effect = null)
    {
        parent::__construct($source, $name, $mp, $accuracy);
        $this->type = $type;
        $this->minDamage = $min;
        $this->maxDamage = $max;
        $this->effect = $effect;
        $this->crit = $crit;
    }

    private function calculateTypeMultiplier($enemy)
    {
        // grass, fire, water

        $move = $this->type;

        if ($move == 1 and $enemy == 2) return .7;
        if ($move == 1 and $enemy == 3) return 1.4;

        if ($move == 2 and $enemy == 3) return .7;
        if ($move == 2 and $enemy == 1) return 1.4;

        if ($move == 3 and $enemy == 1) return .7;
        if ($move == 3 and $enemy == 2) return 1.4;

        return 1;
    }

    public function execute($target)
    {
        $message = "";

        if (!$this->moveSuccess()) {
            $this->source->reduceMP($this->mp);
            return;
        }

        $this->source->reduceMP($this->mp);

        $mult = $this->calculateTypeMultiplier($target->getType());
        $damage =  floor($mult * rand($this->minDamage, $this->maxDamage));

        $crit = rand(1, 100) < $this->crit * 100 ? true : false;

        if ($crit) {
            $damage = floor($damage * 1.5);
        }

        $target->reduceHP($damage);
        $message .= $this->source->getName() . " used " . $this->name . " for $damage damage. " . ($crit ? "It was a critical hit! " : "");

        if ($this->effect) {
            if ($this->effect == 'HPGAIN') {
                $this->source->addHP($this->maxDamage);
                $message .= $this->source->getName() . " restored " . $this->maxDamage . " HP. ";
            }

            if ($this->effect == 'RECOIL') {
                $this->source->reduceHP(floor($damage * .3));
                $message .= $this->source->getName() . " took " . floor($damage * .4) . " from recoil. ";
            }
        }

        if ($mult == .7) $message .= "It was not very effective. ";
        if ($mult == 1.4) $message .= "It was very effective! ";

        Game::log($message);
        return true;
    }

    public function addCrit($a) {
        $this->crit += $a;
    }
}
