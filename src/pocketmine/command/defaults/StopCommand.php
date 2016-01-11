<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;


class StopCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.stop.description",
			"%commands.stop.usage"
		);
		$this->setPermission("pocketmine.command.stop");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		Command::broadcastCommandMessage($sender, new TranslationContainer("commands.stop.start"));

	        if(count($args) < 1){
	            $reason = "Server Closed";
	        }else{
	            $reason = implode(" ", $args);
	        }
	        foreach($sender->getServer()->getOnlinePlayers() as $p){
				$p->kick($reason, false);
	        }
		
		$sender->getServer()->shutdown();

		return true;
	}
}
