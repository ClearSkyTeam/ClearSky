<?php
namespace pocketmine\command;

use pocketmine\event\TranslationContainer;
use pocketmine\plugin\Plugin;


class PluginCommand extends Command implements PluginIdentifiableCommand{

	/** @var Plugin */
	private $owningPlugin;

	/** @var CommandExecutor */
	private $executor;

	/**
	 * @param string $name
	 * @param Plugin $owner
	 */
	public function __construct($name, Plugin $owner){
		parent::__construct($name);
		$this->owningPlugin = $owner;
		$this->executor = $owner;
		$this->usageMessage = "";
	}

	public function execute(CommandSender $sender, $commandLabel, array $args){

		if(!$this->owningPlugin->isEnabled()){
			return false;
		}

		if(!$this->testPermission($sender)){
			return false;
		}

		$success = $this->executor->onCommand($sender, $this, $commandLabel, $args);

		if(!$success and $this->usageMessage !== ""){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));
		}

		return $success;
	}

	public function getExecutor(){
		return $this->executor;
	}

	/**
	 * @param CommandExecutor $executor
	 */
	public function setExecutor(CommandExecutor $executor){
		$this->executor = ($executor != null) ? $executor : $this->owningPlugin;
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin(){
		return $this->owningPlugin;
	}
}
