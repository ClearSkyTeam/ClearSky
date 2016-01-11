<?php
namespace pocketmine\event\weather;

use pocketmine\event\Event;
use pocketmine\level\Level;

abstract class WeatherEvent extends Event{
    private $level;

    public function __construct(Level $level){
        $this->level = $level;
    }

    public function getLevel(){
        return $this->level;
    }
}