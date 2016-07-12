<?php
namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;

class SummonCommand extends VanillaCommand{

	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.summon.description",
			"%pocketmine.command.summon.usage"
		);
		$this->setPermission("pocketmine.command.summon");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) < 1){
			$sender->sendMessage(new TranslationContainer("commands.generic.usage", [$this->usageMessage]));

			return true;
		}

		$player = $sender->getServer()->getPlayer($sender->getName());
		$entitytype = $args[0];
		
		if(!isset($args[1], $args[2], $args[3])){
			$position = $player->getPosition();
		}else{
			$position = new Position($args[1], $args[2], $args[3], $player->getLevel());
		}

		$chunk = $position->getLevel()->getChunk($position->getX() >> 4, $position->getZ() >> 4, true);

		if(!($chunk instanceof FullChunk) || $args[2] < 0 || $args[2] > 128){
			$sender->sendMessage(new TranslationContainer("%commands.summon.outOfWorld"));
			return false;
		}
		$nbt = new CompoundTag("", [
			"Pos" => new ListTag("Pos", [
				new DoubleTag("", $position->getX() + 0.5),
				new DoubleTag("", $position->getY()),
				new DoubleTag("", $position->getZ() + 0.5)
			]),
			"Motion" => new ListTag("Motion", [
				new DoubleTag("", 0),
				new DoubleTag("", 0),
				new DoubleTag("", 0)
			]),
			"Rotation" => new ListTag("Rotation", [
				new FloatTag("", lcg_value() * 360),
				new FloatTag("", 0)
			]),
		]);
		$entity = Entity::createEntity($entitytype, $chunk, $nbt);
		
		if(isset($args[4])){
			$tags = $exception = null;
			$data = implode(" ", array_slice($args, 4));
			try{
				$tags = NBT::parseJSON($data);
			}catch (\Exception $ex){
				$exception = $ex;
			}

			if(!($tags instanceof CompoundTag) or $exception !== null){
				$sender->sendMessage(new TranslationContainer("%commands.summon.tagError", [$exception !== null ? $exception->getMessage() : "Invalid tag conversion"]));
				return true;
			}
			$entity->setNameTag($tags);
		}

		if($player instanceof Player){
			if($entity === null){
				$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.summon.failed"));

				return true;
			}

			//TODO: overflow
			$position->getLevel()->addEntity(clone $entity);
			$entity->spawnToAll();
		}else{
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));

			return true;
		}

		Command::broadcastCommandMessage($sender, new TranslationContainer("%commands.summon.success", [
			$entity->getName() . " (" . $entity->getId() . ":" . $entity->getName() . ")",
			$entity->getNameTag(),
			$player->getName()
		]));
		return true;
	}
}