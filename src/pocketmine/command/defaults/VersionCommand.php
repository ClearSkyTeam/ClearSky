<?php
namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\network\protocol\Info;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class VersionCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.version.description",
			"%pocketmine.command.version.usage",
			["ver", "about"]
		);
		$this->setPermission("pocketmine.command.version");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return \true;
		}

		if(\count($args) === 0){
			$sender->sendMessage(new TranslationContainer("pocketmine.server.info.extended", [
				$sender->getServer()->getName(),
				$sender->getServer()->getPocketMineVersion(),
				$sender->getServer()->getCodename(),
				$sender->getServer()->getApiVersion(),
				$sender->getServer()->getVersion(),
				Info::CURRENT_PROTOCOL
			]));
		}else{
			$pluginName = \implode(" ", $args);
			$exactPlugin = $sender->getServer()->getPluginManager()->getPlugin($pluginName);

			if($exactPlugin instanceof Plugin){
				$this->describeToSender($exactPlugin, $sender);

				return \true;
			}

			$found = \false;
			$pluginName = \strtolower($pluginName);
			foreach($sender->getServer()->getPluginManager()->getPlugins() as $plugin){
				if(\stripos($plugin->getName(), $pluginName) !== \false){
					$this->describeToSender($plugin, $sender);
					$found = \true;
				}
			}

			if(!$found){
				$sender->sendMessage(new TranslationContainer("pocketmine.command.version.noSuchPlugin"));
			}
		}

		return \true;
	}

	private function describeToSender(Plugin $plugin, CommandSender $sender){
		$desc = $plugin->getDescription();
		$sender->sendMessage(TextFormat::DARK_GREEN . $desc->getName() . TextFormat::WHITE . " version " . TextFormat::DARK_GREEN . $desc->getVersion());

		if($desc->getDescription() != \null){
			$sender->sendMessage($desc->getDescription());
		}

		if($desc->getWebsite() != \null){
			$sender->sendMessage("Website: " . $desc->getWebsite());
		}

		if(\count($authors = $desc->getAuthors()) > 0){
			if(\count($authors) === 1){
				$sender->sendMessage("Author: " . \implode(", ", $authors));
			}else{
				$sender->sendMessage("Authors: " . \implode(", ", $authors));
			}
		}
	}
}