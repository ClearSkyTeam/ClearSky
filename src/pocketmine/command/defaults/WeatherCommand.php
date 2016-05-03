<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class WeatherCommand extends VanillaCommand{

    public function __construct($name){
        parent::__construct(
            $name,
            "%pocketmine.command.weather.description",
            "%pocketmine.command.weather.usage"
        );
        $this->setPermission("pocketmine.command.weather.clear;pocketmine.command.weather.rain;pocketmine.command.weather.thunder");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args){
        if(!$this->testPermission($sender)){
            return true;
        }

        if(count($args) > 3 || count($args) === 0){
            $sender->sendMessage(new TranslationContainer("commands.weather.usage", [$this->usageMessage]));
            return false;
        }

        if(count($args) > 1){
			if(is_numeric($args[1]) && $args[1] > 0){
				$seconds = (int) $args[1];
			}else{
	            $sender->sendMessage(new TranslationContainer("commands.weather.usage", [$this->usageMessage]));
	            return false;
			}
        }else{
            $seconds = 600*20;
        }
		
		if(count($args) < 2){
       		if($sender instanceof Player){
            	$level = $sender->getLevel();
			}else{
				$level = $sender->getServer()->getDefaultLevel();
        	}
	    }else{
		if(!$sender->getServer()->isLevelLoaded($args[2])){
                	$sender->getServer()->loadLevel($args[2]);
                	$level = $sender->getServer()->getLevelByName($args[2]);
			if(!$sender->getServer()->isLevelLoaded($args[2])){
                    		$worldName = $args[2];
                                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "commands.weather.worldnotfound", $args[2]));
		         	return false;
	            	}
	        }else{
	            $level = $sender->getServer()->getLevelByName($args[2]);
	        }
        }

        if($args[0] === "clear"){
            if(!$sender->hasPermission("pocketmine.command.weather.clear")){
                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.permission"));
                return true;
            }

            $level->setWeather(Level::WEATHER_CLEARSKY);

            Command::broadcastCommandMessage($sender, new TranslationContainer("commands.weather.clear"));

            return true;

        }elseif($args[0] === "rain"){
            if(!$sender->hasPermission("pocketmine.command.weather.rain")){
                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.permission"));
                return true;
            }
			
			if(isset($args[1]) and is_numeric($args[1]) and $args[1] > 0){
				$time = $args[1];
			}else{
				$time = 120;
			}
			
            $level->setWeather(Level::WEATHER_RAIN,$time);

            Command::broadcastCommandMessage($sender, new TranslationContainer("commands.weather.rain"));

            return true;

        }elseif($args[0] === "thunder"){
            if(!$sender->hasPermission("pocketmine.command.weather.thunder")){
                $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.permission"));
                return true;
            }
             //WEATHER TODO : THUNDER
            //$level->setThundering(true);
            //$level->setRainTime($seconds * 20);
            //$level->setThunderTime($seconds * 20);

            Command::broadcastCommandMessage($sender,"WIP"/* new TranslationContainer("commands.weather.thunder")*/);

            return true;

        }else{
            $sender->sendMessage(new TranslationContainer("commands.weather.usage",  [$this->usageMessage]));
            return false;
        }
    }
}
