<?php
namespace pocketmine\item;

use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\entity\Entity;
use pocketmine\Player;

abstract class Launchable extends Item{
	public function launch(Player $player){
		$dir = $player->getDirectionVector();
 		$frontPos = $player->add($dir->multiply(1.1));
 		$nbt = new Compound("", ["Pos" => new Enum("Pos", [new Double("", $frontPos->x),new Double("", $frontPos->y + $player->getEyeHeight()),new Double("", $frontPos->z)]),
 							"Motion" => new Enum("Motion", [new Double("", $dir->x),new Double("", $dir->y),new Double("", $dir->z)]),"Rotation" => new Enum("Rotation", [new Float("", 0),new Float("", 0)])]);
		$f = 1.1;
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