<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class ExpCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct($name, "%pocketmine.command.xp.description","%commands.xp.usage", []);
		$this->setPermission("pocketmine.command.xp");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		
		if(count($args) > 0){
			$inputAmount = $args[0];
			$player = null;
			
			$isLevel = $this->endsWith($inputAmount, "l") || $this->endsWith($inputAmount, "L");
			if($isLevel && strlen($inputAmount) > 1){
				$inputAmount = substr($inputAmount, 0, strlen($inputAmount) - 1);
			}
			
			$amount = intval($inputAmount);
			$isTaking = $amount < 0;
			
			if($isTaking){
				$amount *= -1;
			}
			
			if(count($args) > 1){
				$player = $sender->getServer()->getPlayer($args[1]);
			}
			elseif($sender instanceof Player){
				$player = $sender;
			}
			
			if($player != null){
				if($isLevel){
					if($isTaking){
						$player->addExpLevel(-$amount);
						Command::broadcastCommandMessage($sender, new TranslationContainer("commands.xp.taken.level", [$amount, $player->getName()]));
					}
					else{
						$player->addExpLevel($amount);
						Command::broadcastCommandMessage($sender, new TranslationContainer("commands.xp.given.level", [$amount, $player->getName()]));
					}
				}
				else{
					if($isTaking){
						Command::broadcastCommandMessage($sender, new TranslationContainer(TextFormat::RED . "commands.xp.taken", []));
						return false;
					}
					else{
						$player->addExperience($amount);
						Command::broadcastCommandMessage($sender, new TranslationContainer("commands.xp.given", [$amount, $player->getName()]));
					}
				}
			}
			else{
				$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
				return false;
			}
			
			return true;
		}
		
		$sender->sendMessage(TextFormat::RED . "Usage: " . $this->usageMessage);
		return false;
	}
	
	// $sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
	// Command::broadcastCommandMessage($sender, new TranslationContainer("%commands.give.success", [$xp->getName() . " (" . $xp->getId() . ":" . $xp->getDamage() . ")",(string) $xp->getCount(),$player->getName()]));
	public function endsWith($haystack, $needle){
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}
}
