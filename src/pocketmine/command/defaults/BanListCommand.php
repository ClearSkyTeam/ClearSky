<?php
namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;


class BanListCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.banlist.description",
			"%commands.banlist.usage"
		);
		$this->setPermission("pocketmine.command.ban.list");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}
		$list = $sender->getServer()->getNameBans();
		if(isset($args[0])){
			$args[0] = strtolower($args[0]);
			if($args[0] === "ips"){
				$list = $sender->getServer()->getIPBans();
			}elseif($args[0] === "players"){
				$list = $sender->getServer()->getNameBans();
			}else{
				$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

				return false;
			}
		}else{
			$list = $sender->getServer()->getNameBans();
			$args[0] = "players";
		}

		$message = "";
		$list = $list->getEntries();
		foreach($list as $entry){
			$message .= $entry->getName() . ", ";
		}

		if($args[0] === "ips"){
			$sender->sendMessage(new TranslationContainer("commands.banlist.ips", [count($list)]));
		}else{
			$sender->sendMessage(new TranslationContainer("commands.banlist.players", [count($list)]));
		}

		$sender->sendMessage(substr($message, 0, -2));

		return true;
	}
}