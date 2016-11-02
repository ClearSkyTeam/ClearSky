<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;

abstract class VanillaCommand extends Command{
	const MAX_COORD = 30000000;
	const MIN_COORD = -30000000;

	public function __construct($name, $description = "", $usageMessage = null, array $aliases = []){
		parent::__construct($name, $description, $usageMessage, $aliases);
		$this->commandData = $this->generateCustomData();
	}

	protected function getInteger(CommandSender $sender, $value, $min = self::MIN_COORD, $max = self::MAX_COORD){
		$i = (int) $value;

		if($i < $min){
			$i = $min;
		}elseif($i > $max){
			$i = $max;
		}

		return $i;
	}

	protected function getRelativeDouble($original, CommandSender $sender, $input, $min = self::MIN_COORD, $max = self::MAX_COORD){
		if($input{0} === "~"){
			$value = $this->getDouble($sender, substr($input, 1));

			return $original + $value;
		}

		return $this->getDouble($sender, $input, $min, $max);
	}

	protected function getDouble(CommandSender $sender, $value, $min = self::MIN_COORD, $max = self::MAX_COORD){
		$i = (double) $value;

		if($i < $min){
			$i = $min;
		}elseif($i > $max){
			$i = $max;
		}

		return $i;
	}

	public function generateCustomData(): \stdClass{
		$all = json_decode(file_get_contents(Server::getInstance()->getFilePath() . "src/pocketmine/resources/standard.json"));
		if(@$all->{$this->getName()} !== null){
			$data = clone end($all->{$this->getName()}->versions); // move pointer to last key. See @link http://stackoverflow.com/questions/14631804/php-last-key-of-object
		}
		else $data = $this->getDefaultCommandData();
		return clone $data;
	}
}