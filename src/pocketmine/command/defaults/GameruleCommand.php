<?php

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\level\GameRules;

class GameruleCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct($name, "%pocketmine.command.gamerule.description", "%commands.gamerule.usage");
		$this->setPermission("pocketmine.command.gamerule");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		
		if(!$sender instanceof Player){
			$sender->sendMessage("This currently only works for players");
		}
		
		$gamerules = $sender->getLevel()->getGameRules();
		$s = count($args) > 0?$args[0]:"";
		
		switch(count($args)){
			case 0:
				$sender->sendMessage(TextFormat::YELLOW . "Gamerules:\n");//We are cooler than MC client. We tell the players the values too, not only keys!
				foreach($gamerules->getRulesArray() as $key => $value){
					$sender->sendMessage(TextFormat::YELLOW . '"' . $key . '" = "' . $value . '"');
				}
				break;
			case 1:
				
				if(!$gamerules->hasRule($s)){
					$sender->sendMessage(new TranslationContainer("commands.gamerule.norule", [$s]));
					return false;
				}
				
				$s2 = $gamerules->getRulesArray()[$s];
				$sender->sendMessage(TextFormat::YELLOW . $s . " = " . $s2);
				break;
			default:
				$s1 = $args[1];
				if($gamerules->hasRule($s) && $gamerules->areSameType($s, $s2 = $gamerules->getRulesArray()[$s]) && !"true" === $s1 && !"false" === $s1){
					$sender->sendMessage(new TranslationContainer("commands.generic.boolean.invalid", [$s]));
					return false;
				}
				
				$gamerules->setOrCreateGameRule($s, $s1);
				$this->broadcastCommandMessage($sender, new TranslationContainer("commands.gamerule.success", [$s, $s1]), true);
		}
		
		return true;
	}
}