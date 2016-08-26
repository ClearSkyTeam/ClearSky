<?php
namespace pocketmine\level;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityExplodeEvent;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Math;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\network\Network;
use pocketmine\network\protocol\ExplodePacket;
use pocketmine\Server;
use pocketmine\utils\Random;
class Explosion extends Level{ //implements vector iterator
	private $rays = 16;
	public $level;
	public $source;
	public $size;
	public $affectedBlocks = [];
	public $stepLen = 0.3;
	private $what;
	public function __construct(Position $center, $size, $what = null){
		$this->level = $center->getLevel();
		$this->source = $center;
		$this->size = max($size, 0);
		$this->what = $what;
	}
	public function explode(){
		if($this->explodeA()){
			return $this->explodeB();
		}
		return false;
	}
	public function explodeA(){
		if($this->size < 0.1){
			return false;
		}
		$vector = new Vector3(0, 0, 0);
		$vBlock = new Vector3(0, 0, 0);
		$mRays = intval($this->rays - 1);
		for((int) $i = 0; $i < $this->rays; ++$i){
			for((int) $j = 0; $j < $this->rays; ++$j){
				for((int) $k = 0; $k < $this->rays; ++$k){
					if($i == 0 || $i == $mRays || $j == 0 || $j == $mRays || $k == 0 || $k == $mRays){
						$vector->setComponents((double) $i / (double) $mRays * 2 - 1, (double) $j / (double) $mRays * 2 - 1, (double) $k / (double) $mRays * 2 - 1);
						(double) $len = $vector->length();
						$vector->setComponents(($vector->x / $len) * $this->stepLen, ($vector->y / $len) * $this->stepLen, ($vector->z / $len) * $this->stepLen);
						(double) $pointerX = $this->source->x;
						(double) $pointerY = $this->source->y;
						(double) $pointerZ = $this->source->z;
						for((double) $blastForce = $this->size * (mt_rand(700, 1300) / 1000); $blastForce > 0; $blastForce -= $this->stepLen * 0.75){
							(int) $x = (int) $pointerX;
							(int) $y = (int) $pointerY;
							(int) $z = (int) $pointerZ;
							$vBlock->x = $pointerX >= $x ? $x : $x - 1;
							$vBlock->y = $pointerY >= $y ? $y : $y - 1;
							$vBlock->z = $pointerZ >= $z ? $z : $z - 1;
							if($vBlock->y < 0 or $vBlock->y > 127){
								break;
							}
							$block = $this->level->getBlock($vBlock);
							if($block->getId() !== 0){
								$blastForce -= ($block->getResistance() / 5 + 0.3) * $this->stepLen;
								if($blastForce > 0){
									if(!isset($this->affectedBlocks[$index = Level::blockHash((int) $block->x, (int) $block->y, (int) $block->z)])){
										$this->affectedBlocks[$index] = $block;
									}
								}
							}
							$pointerX += $vector->x;
							$pointerY += $vector->y;
							$pointerZ += $vector->z;
						}
					}
				}
			}
		}
		return true;
	}
	public function explodeB(){
		$send = [];
		$source = (new Vector3($this->source->x, $this->source->y, $this->source->z))->floor();
		(double) $yield = (1 / $this->size) * 100;
		(double) $explosionSize = $this->size * 2;
		(double) $minX = Math::floorFloat($this->source->x - $explosionSize - 1);
		(double) $maxX = Math::ceilFloat($this->source->x + $explosionSize + 1);
		(double) $minY = Math::floorFloat($this->source->y - $explosionSize - 1);
		(double) $maxY = Math::ceilFloat($this->source->y + $explosionSize + 1);
		(double) $minZ = Math::floorFloat($this->source->z - $explosionSize - 1);
		(double) $maxZ = Math::ceilFloat($this->source->z + $explosionSize + 1);
		$explosionBB = new AxisAlignedBB($minX, $minY, $minZ, $maxX, $maxY, $maxZ);
		if($this->what instanceof Entity){
			$this->level->getServer()->getPluginManager()->callEvent($ev = new EntityExplodeEvent($this->what, $this->source, $this->affectedBlocks, $yield));
			if($ev->isCancelled()){
				return false;
			}else{
				$yield = $ev->getYield();
				$this->affectedBlocks = $ev->getBlockList();
			}
		}
		$list = $this->level->getNearbyEntities($explosionBB, $this->what instanceof Entity ? $this->what : null);
		foreach($list as $entity){
			(double) $distance = $entity->distance($this->source) / $explosionSize;
			if($distance <= 1){
				$motion = $entity->subtract($this->source)->normalize();
				(double) $impact = (1 - $distance) * ($exposure = 1);
				(int) $exposure = 1;
				(int) $damage = (int) ((($impact * $impact + $impact) / 2) * 8 * $explosionSize + 1);
				if($this->what instanceof Entity){
					$ev = new EntityDamageByEntityEvent($this->what, $entity, EntityDamageEvent::CAUSE_ENTITY_EXPLOSION, $damage);
				}elseif($this->what instanceof Block){
					$ev = new EntityDamageByBlockEvent($this->what, $entity, EntityDamageEvent::CAUSE_BLOCK_EXPLOSION, $damage);
				}else{
					$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_BLOCK_EXPLOSION, $damage);
				}
				$entity->attack($ev->getFinalDamage(), $ev);
				$entity->setMotion($motion->multiply($impact));
			}
		}
		$air = Item::get(Item::AIR);
		foreach($this->affectedBlocks as $block){
			if($block->getId() === Block::TNT){
				(double) $mot = (new Random())->nextSignedFloat() * M_PI * 2;
				$tnt = Entity::createEntity("PrimedTNT", $this->level->getChunk((int) $block->x >> 4, (int) $block->z >> 4), new CompoundTag("", [
					"Pos" => new ListTag("Pos", [
						new DoubleTag("", $block->x + 0.5),
						new DoubleTag("", $block->y),
						new DoubleTag("", $block->z + 0.5)
					]),
					"Motion" => new ListTag("Motion", [
						new DoubleTag("", -sin($mot) * 0.02),
						new DoubleTag("", 0.2),
						new DoubleTag("", -cos($mot) * 0.02)
					]),
					"Rotation" => new ListTag("Rotation", [
						new FloatTag("", 0),
						new FloatTag("", 0)
					]),
					"Fuse" => new ByteTag("Fuse", mt_rand(10, 30))
				]));
				$tnt->spawnToAll();
			}elseif(mt_rand(0, 100) < $yield){
				foreach($block->getDrops($air) as $drop){
					$this->level->dropItem($block->add(0.5, 0.5, 0.5), Item::get(...$drop));
				}
			}
			$this->level->setBlockIdAt((int) $block->x, (int) $block->y, (int) $block->z, 0);
			
			$pos = new Vector3($block->x, $block->y, $block->z);
			for($side = 0; $side < 5; $side++){
				$sideBlock = $pos->getSide($side);
				if(!isset($this->affectedBlocks[$index = Level::blockHash($sideBlock->x, $sideBlock->y, $sideBlock->z)]) and !isset($updateBlocks[$index])){
					$this->level->getServer()->getPluginManager()->callEvent($ev = new BlockUpdateEvent($this->level->getBlock($sideBlock)));
					if(!$ev->isCancelled()){
						$ev->getBlock()->onUpdate(Level::BLOCK_UPDATE_NORMAL);
					}
					$updateBlocks[$index] = true;
				}
			}
			$send[] = new Vector3($block->x - $source->x, $block->y - $source->y, $block->z - $source->z);
		}
		$pk = new ExplodePacket();
		$pk->x = (float) $this->source->x;
		$pk->y = (float) $this->source->y;
		$pk->z = (float) $this->source->z;
		$pk->radius = (float) $this->size;
		$pk->records = $send;
		$this->level->addChunkPacket($source->x >> 4, $source->z >> 4, $pk);
		return true;
	}
}
