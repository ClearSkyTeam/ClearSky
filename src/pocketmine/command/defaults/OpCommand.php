<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class OpCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.op.description",
			"%commands.op.usage"
		);
		$this->setPermission("pocketmine.command.op.give");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return false;
		}

		$name = array_shift($args);

		$player = $sender->getServer()->getOfflinePlayer($name);
		Command::broadcastCommandMessage($sender, new TranslationContainer("commands.op.success", [$player->getName()]));
		if($player instanceof Player){
			$player->sendMessage(TextFormat::GRAY . "You are now op!");
		}
		$player->setOp(true);
		return true;
	}
}