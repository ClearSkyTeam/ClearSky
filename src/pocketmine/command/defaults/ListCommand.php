<?php
namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;


class ListCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.list.description",
			"%command.players.usage"
		);
		$this->setPermission("pocketmine.command.list");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		$online = "";
		$onlineCount = 0;

		foreach($sender->getServer()->getOnlinePlayers() as $player){
			if($player->isOnline() and (!($sender instanceof Player) or $sender->canSee($player))){
				$online .= $player->getDisplayName() . ", ";
				++$onlineCount;
			}
		}

		$sender->sendMessage(new TranslationContainer("commands.players.list", [$onlineCount, $sender->getServer()->getMaxPlayers()]));
		$sender->sendMessage(substr($online, 0, -2));

		return true;
	}
}