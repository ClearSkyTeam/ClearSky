<?php
namespace pocketmine\event\weather;

use pocketmine\event\Cancellable;
use pocketmine\level\Level;

class WeatherChangeEvent extends WeatherEvent implements Cancellable{
    public static $handlerList = null;
    private $to;

    public function __construct(Level $level, $to = false){
        parent::__construct($level);
        $this->to = $to;
    }

    public function getWeatherState(){
        return $this->to;
    }
}