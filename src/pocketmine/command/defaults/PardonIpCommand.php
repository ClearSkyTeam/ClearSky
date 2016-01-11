<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;


class PardonIpCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.unban.ip.description",
			"%commands.unbanip.usage"
		);
		$this->setPermission("pocketmine.command.unban.ip");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) !== 1){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return false;
		}

		if(preg_match("/^([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])$/", $args[0])){
			$sender->getServer()->getIPBans()->remove($args[0]);
			Command::broadcastCommandMessage($sender, new TranslationContainer("commands.unbanip.success", [$args[0]]));
		}else{
			$sender->sendMessage(new TranslationContainer("commands.unbanip.invalid"));
		}

		return true;
	}
}