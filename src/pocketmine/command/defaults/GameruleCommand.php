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
		
		if(count($args) !== 1){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
			
			return false;
		}
		
		$gamerules = $sender->getLevel()->getGameRules(); // todo
		$s = count($args) > 0?$args[0]:"";
		// $s1 = count($args) > 1 ? $this->buildString($args, 1) : "";//? Hההה wat willst du
		
		switch(count($args)){
			case 0:
				$sender->sendMessage(implode(var_export($gamerules->getRules(), true), "\n" . TextFormat::YELLOW));
				break;
			case 1:
				
				if(!$gamerules->hasRule($s)){
					$sender->sendMessage(new TranslationContainer("commands.gamerule.norule", $s));
					return false;
				}
				
				$s2 = $gamerules->getString($s);
				$sender->sendMessage($s . " = " . $s2);
				break;
			default:
				
				if($gamerules->areSameType($s, GameRules::BOOLEAN_VALUE) && !"true" . equals(s1) && !"false" . equals(s1)){
					$sender->sendMessage(new TranslationContainer("commands.generic.boolean.invalid", $s));
					return false;
				}
				
				$gamerules->setOrCreateGameRule($s, $s1);
				// func_184898_a(gamerules, s, server);//notify server
				$sender->getServer()->broadcastMessage(new TranslationContainer("commands.gamerule.success", $s, $s1), $sender->getServer()->getOps());
		}
		
		return true;
	}
}