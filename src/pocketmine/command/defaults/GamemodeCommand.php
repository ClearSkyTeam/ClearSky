<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class GamemodeCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.gamemode.description",
			"%commands.gamemode.usage",
			["gm"]
		);
		$this->setPermission("pocketmine.command.gamemode");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return false;
		}

		$gameMode = Server::getGamemodeFromString($args[0]);

		if($gameMode === -1){
			$sender->sendMessage("Unknown game mode");

			return true;
		}

		$target = $sender;
		if(isset($args[1])){
			$target = $sender->getServer()->getPlayer($args[1]);
			if($target === null){
				$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));

				return true;
			}
		}elseif(!($sender instanceof Player)){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return true;
		}

		$target->setGamemode($gameMode);
		if($gameMode !== $target->getGamemode()){
			$sender->sendMessage("Game mode change for " . $target->getName() . " failed!");
		}else{
			if($target === $sender){
				Command::broadcastCommandMessage($sender, new TranslationContainer("commands.gamemode.success.self", [Server::getGamemodeString($gameMode)]));
			}else{
				$target->sendMessage(new TranslationContainer("gameMode.changed"));
				Command::broadcastCommandMessage($sender, new TranslationContainer("commands.gamemode.success.other", [$target->getName(), Server::getGamemodeString($gameMode)]));
			}
		}

		return true;
	}
}