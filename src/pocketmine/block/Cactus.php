<?php
namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;

class Cactus extends Transparent{

	protected $id = self::CACTUS;
	public $exp_smelt = 0.2;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 0.4;
	}

	public function hasEntityCollision(){
		return true;
	}

	public function getName(){
		return "Cactus";
	}

	protected function recalculateBoundingBox(){
		return new AxisAlignedBB(
			$this->x + 0.0625,
			$this->y + 0.0625,
			$this->z + 0.0625,
			$this->x + 0.9375,
			$this->y + 0.9375,
			$this->z + 0.9375
		);
	}

	public function onEntityCollide(Entity $entity){
		$ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageEvent::CAUSE_CONTACT, 1);
		$entity->attack($ev->getFinalDamage(), $ev);
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			$down = $this->getSide(0);
			$up = $this->getSide(1);
			if($down->getId() !== self::SAND and $down->getId() !== self::CACTUS){
				$this->getLevel()->scheduleUpdate($this, 0);
			}else{
				for($side = 2; $side <= 5; ++$side){
					$b = $this->getSide($side);
					if(!$b->canBeFlowedInto()){
						$this->getLevel()->useBreakOn($this);
					}
				}
			}
		}elseif($type === Level::BLOCK_UPDATE_RANDOM){
			if($this->getSide(0)->getId() !== self::CACTUS){
				if($this->meta == 0x0F){
					for($y = 1; $y < 3; ++$y){
						$b = $this->getSide(1);
						if($b->getId() === self::AIR){
							Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($b, new Cactus()));
							if(!$ev->isCancelled()){
								$this->getLevel()->setBlock($b, $ev->getNewState(), true);
							}
						}
					}
					$this->meta = 0;
					$this->getLevel()->setBlock($this, $this);
				}else{
					++$this->meta;
					$this->getLevel()->setBlock($this, $this);
				}
			}
		}elseif($type === Level::BLOCK_UPDATE_SCHEDULED){
			$this->getLevel()->useBreakOn($this);
		}

		return false;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->getId() === self::SAND or $down->getId() === self::CACTUS){
			for($side = 2; $side <= 5; ++$side){
				$b = $this->getSide($side);
				if(!$b->canBeFlowedInto()){
					return false;
				}
			}
			$this->getLevel()->setBlock($this, $this, true);
			return true;
		}

		return false;
	}

	public function getDrops(Item $item){
		return [
			[$this->id, 0, 1],
		];
	}
}