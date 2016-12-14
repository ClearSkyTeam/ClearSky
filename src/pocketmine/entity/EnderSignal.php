<?php
namespace pocketmine\entity;

use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\item\Item as ItemItem;

class EnderSignal extends Entity{
	const NETWORK_ID = 70;

	public $width = 0;
	public $length = 0;
	public $height = 0;

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		parent::__construct($chunk, $nbt);
	}

	public function onUpdate($currentTick){
		if($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);

		if($this->age > 50){
			$this->kill();
			$hasUpdate = true;
			$this->getLevel()->dropItem($this, ItemItem::get(ItemItem::EYE_OF_ENDER), $this);
		}

		$this->timings->stopTiming();

		return $hasUpdate;
	}

	public function getName(){
		return "Eye of Ender";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = self::NETWORK_ID;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}