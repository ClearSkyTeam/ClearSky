<?php
namespace pocketmine\item;

use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\event\entity\ProjectileLaunchEvent;


class Launchable extends Item{
	public function launch(Player $player){
 		$nbt = new Compound("", [
			"Pos" => new Enum("Pos", [
				new Double("", $player->x),
				new Double("", $player->y + $player->getEyeHeight()),
				new Double("", $player->z)
			]),
 			"Motion" => new Enum("Motion", [
				new Double("", -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
				new Double("", -sin($player->pitch / 180 * M_PI)),
				new Double("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI))
			]),
			"Rotation" => new Enum("Rotation", [
				new Float("", $player->yaw),
				new Float("", $player->pitch)
			]),
			"Data" => new Byte("Data", $this->getDamage()),
		]);
		$f = $this->f;
		$launched = Entity::createEntity($this->getEntityName(), $player->chunk, $nbt, $player);
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
		return true;
	}
}