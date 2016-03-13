<?php
namespace pocketmine\block;

use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityCombustByBlockEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\level\sound\FizzSound;

class Fire extends Flowable implements LightSource{

	protected $id = self::FIRE;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function hasEntityCollision(){
		return true;
	}

	public function getName(){
		return "Fire Block";
	}

	public function getLightLevel(){
		return 15;
	}
	
	public function getHardness(){
		return 0;
	}

	public function isLightSource(){
		return true;
	}

	public function canBeReplaced(){
		return true;
	}

	public function onEntityCollide(Entity $entity){
		if(!$entity->hasEffect(Effect::FIRE_RESISTANCE)){
			$ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageEvent::CAUSE_FIRE, 1);
			$entity->attack($ev->getFinalDamage(), $ev);
		}

		$ev = new EntityCombustByBlockEvent($this, $entity, 8);
		if($entity instanceof Arrow){
			$ev->setCancelled();
		}
		Server::getInstance()->getPluginManager()->callEvent($ev);
		if(!$ev->isCancelled()){
			$entity->setOnFire($ev->getDuration());
		}
	}

	public function getDrops(Item $item){
		return [];
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			for($s = 0; $s <= 5; ++$s){
				$side = $this->getSide($s);
				if(!($side instanceof Transparent) and !($side instanceof Liquid)){
					return false;
				}
			}
			$this->getLevel()->useBreakOn($this);

			return Level::BLOCK_UPDATE_NORMAL;
		}elseif($type === Level::BLOCK_UPDATE_RANDOM){
			if($this->getSide(0)->getId() !== self::NETHERRACK){
				if(mt_rand(0, 2) === 0){
					if($this->meta === 0x0F){
						$this->level->setBlock($this, new Air());
					}else{
						$this->meta++;
						$this->level->setBlock($this, $this);
					}

					return Level::BLOCK_UPDATE_NORMAL;
				}
			}
		}

		return false;
	}

}