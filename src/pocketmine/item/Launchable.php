<?php
namespace pocketmine\item;

use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\Entity;
use pocketmine\Player;

class Launchable extends Item{
	public function launch(Player $player){
		$dir = $player->getDirectionVector();
 		$frontPos = $player->add($dir->multiply(1.1));
 		$nbt = new CompoundTag("", [
							"Pos" => new ListTag("Pos", [new DoubleTag("", $frontPos->x),new DoubleTag("", $frontPos->y + $player->getEyeHeight()),new DoubleTag("", $frontPos->z)]),
 							"Motion" => new ListTag("Motion", [new DoubleTag("", $dir->x),new DoubleTag("", $dir->y),new DoubleTag("", $dir->z)]),
							"Rotation" => new ListTag("Rotation", [new FloatTag("", 0),new FloatTag("", 0)]),
							"Data" => new ByteTag("Data", $this->getDamage()),
							]);
		$f = $this->f;
		$launched = Entity::createEntity($this->getEntityName(), $player->chunk, $nbt);
		$launched->setMotion($launched->getMotion()->multiply($f));
		if($launched instanceof Projectile){
			$player->server->getPluginManager()->callEvent($projectileEv = new ProjectileLaunchEvent($launched));
			if($projectileEv->isCancelled()){
				$launched->kill();
			}else{
				$launched->spawnToAll();
				$player->level->addSound(new LaunchSound($player), $player->getViewers());
			}
		}else{
			$launched->spawnToAll();
		}
	}
}