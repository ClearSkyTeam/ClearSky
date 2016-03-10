<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;


class UpgradeCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.upgrade.description",
			"%commands.upgrade.usage"
		);
		$this->setPermission("pocketmine.command.upgrade");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		
		/*if(!$sender->getServer()->getUpdater()->hasUpdate()){
			$sender->sendMessage(new TranslationContainer("commands.upgrade.noupgrade"));
			return true;
		}*/
		
		Command::broadcastCommandMessage($sender, new TranslationContainer("commands.upgrade.start"));
		$sender->getServer()->getUpdater()->doUpgrade();

		return true;
	}
}
