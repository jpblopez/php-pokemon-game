<?php


abstract class Pokemon {
    protected $hp;
    protected $mp;
    protected $maxHP;
    protected $maxMP;
    protected $type;
    protected $name;
    protected $moves = [];
    protected $playerImage;
    protected $enemyImage;

    public function __construct($name, $type, $hp, $mp, $playerImage, $enemyImage) {
        $this->name = $name;    
        $this->type = $type;    
        $this->hp = $this->maxHP = $hp;    
        $this->mp = $this->maxMP = $mp;
        $this->playerImage = $playerImage;
        $this->enemyImage = $enemyImage;
    }

    public function executeMove($move, $target) {
        $this->moves[$move]->execute($target);
    }

    public function reduceHP($a) {
        $this->hp -= $a;
    }

    public function isDefeated() {
        return $this->hp <= 0;
    }

    public function getPlayerImage() {
        return $this->playerImage;
    }
    public function getEnemyImage() {
        return $this->enemyImage;
    }

    public function getHP () {
        return $this->hp;
    }

    public function addHP($a) {
        $this->hp = $this->hp + $a > $this->maxHP ? $this->maxHP : $this->hp + $a;
    }

    public function getMP() {
        return $this->mp;
    }

    public function getName() {
        return $this->name;
    }

    public function getMoves() {
        return $this->moves;
    }

    public function getMove($move) {
        return $this->moves[$move];
    }

    public function getMaxHP() {
        return $this->maxHP;
    }

    public function getMaxMP() {
        return $this->maxMP;
    }

    public function getType() {
        return $this->type;
    }

    public function reduceMP($a) {
        $this->mp -= $a;
    }

    public function addMP($a) {
        $this->mp = $this->maxMP < $this->mp + $a ? $this->maxMP : $this->mp + $a;
    }   

    public function setName($name) {
        $this->name = $name;
    }
}