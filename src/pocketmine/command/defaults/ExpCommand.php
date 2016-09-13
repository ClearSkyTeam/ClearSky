<?php

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\level\sound\ExpPickupSound;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
class ExpCommand extends VanillaCommand{
	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.xp.description",
			"%commands.xp.usage"
		);
		$this->setPermission("pocketmine.command.xp");
	}
	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		if(count($args) < 2){
			if($sender instanceof ConsoleCommandSender){
				$sender->sendMessage("You must specify a target player in the console");
				return true;
			}
			$player = $sender;
		}else{
			$player = $sender->getServer()->getPlayer($args[1]);
		}
		if($player instanceof Player){
			$name = $player->getName();
			if(strcasecmp(substr($args[0], -1), "L") == 0){ //Set Experience Level(with "L" after args[0])
				$level = (int) rtrim($args[0], "Ll");
				if($level > 0){
					$player->addXpLevel((int) $level);
					$sender->sendMessage(new TranslationContainer("%commands.xp.success.levels", [$level, $name]));
					$player->getLevel()->addSound(new ExpPickupSound($player, mt_rand(0, 1000))); //TODO: Find the level-up sound
					return true;
				}elseif($level < 0){
					$player->takeXpLevel((int) -$level);
					$sender->sendMessage(new TranslationContainer("%commands.xp.success.negative.levels", [-$level, $name]));
					return true;
				}
			}else{
				if(($xp = (int) $args[0]) > 0){ //Set Experience
					$player->addXp((int) $args[0]);
					$player->getLevel()->addSound(new ExpPickupSound($player, mt_rand(0, 1000)));
					$sender->sendMessage(new TranslationContainer("%commands.xp.success", [$name, $args[0]]));
					return true;
				}elseif($xp < 0){ //Stupid, but this lines up with vanilla behaviour, so...
					$sender->sendMessage(new TranslationContainer("%commands.xp.failure.withdrawXp"));
					return true;
				}
			}
			//This statement will only be reached if the command failed
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
			return false;
		}else{
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
			return false;
		}
		return false;
	}
}