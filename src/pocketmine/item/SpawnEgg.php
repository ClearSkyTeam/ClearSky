<?php
namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\level\format\FullChunk;
use pocketmine\level\Level;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\String;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class SpawnEgg extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::SPAWN_EGG, $meta, $count, "Spawn Egg");
	}

	public function canBeActivated(){
		return true;
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$entity = null;
		$chunk = $level->getChunk($block->getX() >> 4, $block->getZ() >> 4);

		if(!($chunk instanceof FullChunk)){
			return false;
		}

		$nbt = new Compound("", [
			"Pos" => new Enum("Pos", [
				new Double("", $block->getX() + 0.5),
				new Double("", $block->getY()),
				new Double("", $block->getZ() + 0.5)
			]),
			"Motion" => new Enum("Motion", [
				new Double("", 0),
				new Double("", 0),
				new Double("", 0)
			]),
			"Rotation" => new Enum("Rotation", [
				new Float("", lcg_value() * 360),
				new Float("", 0)
			]),
		]);

		if($this->hasCustomName()){
			$nbt->CustomName = new String("CustomName", $this->getCustomName());
		}

		$entity = Entity::createEntity($this->meta, $chunk, $nbt);
		if($entity instanceof Entity){
			$entity->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_NO_AI, true);
			$entity->getLevel()->getServer()->broadcastPopup(TextFormat::RED . "Mob AI isn't implemented yet!");
			if($player->isSurvival()){
				--$this->count;
			}
			$entity->spawnToAll();
			return true;
		}
		return false;
	}
}