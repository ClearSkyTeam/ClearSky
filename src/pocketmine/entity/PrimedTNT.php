<?php
namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;

use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\level\Explosion;
use pocketmine\nbt\tag\Byte;
use pocketmine\Player;

class PrimedTNT extends Entity implements Explosive{
	const NETWORK_ID = 65;

	public $width = 0.98;
	public $length = 0.98;
	public $height = 0.98;

	protected $gravity = 0.04;
	protected $drag = 0.02;
	protected $fuse;

	public $canCollide = false;


	public function attack($damage, EntityDamageEvent $source){
		if($source->getCause() === EntityDamageEvent::CAUSE_VOID){
			parent::attack($damage, $source);
		}
	}

	protected function initEntity(){
		parent::initEntity();

		if(isset($this->namedtag->Fuse)){
			$this->fuse = $this->namedtag["Fuse"];
		}else{
			$this->fuse = 80;
		}
	}


	public function canCollideWith(Entity $entity){
		return false;
	}

	public function saveNBT(){
		parent::saveNBT();
		$this->namedtag->Fuse = new Byte("Fuse", $this->fuse);
	}

	public function onUpdate($currentTick){

		if($this->closed){
			return false;
		}

		$this->timings->startTiming();

		$tickDiff = $currentTick - $this->lastUpdate;
		if($tickDiff <= 0 and !$this->justCreated){
			return true;
		}
		$this->lastUpdate = $currentTick;

		$hasUpdate = $this->entityBaseTick($tickDiff);

		if($this->isAlive()){

			$this->motionY -= $this->gravity;

			$this->move($this->motionX, $this->motionY, $this->motionZ);

			$friction = 1 - $this->drag;

			$this->motionX *= $friction;
			$this->motionY *= $friction;
			$this->motionZ *= $friction;

			$this->updateMovement();

			if($this->onGround){
				$this->motionY *= -0.5;
				$this->motionX *= 0.7;
				$this->motionZ *= 0.7;
			}

			$this->fuse -= $tickDiff;

			if($this->fuse <= 0){
				$this->kill();
				$this->explode();
			}

		}

		return $hasUpdate or $this->fuse >= 0 or abs($this->motionX) > 0.00001 or abs($this->motionY) > 0.00001 or abs($this->motionZ) > 0.00001;
	}

	public function explode(){
		$this->server->getPluginManager()->callEvent($ev = new ExplosionPrimeEvent($this, 4));

		if(!$ev->isCancelled()){
			$explosion = new Explosion($this, $ev->getForce(), $this);
			if($ev->isBlockBreaking()){
				$explosion->explodeA();
			}
			$explosion->explodeB();
		}
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = PrimedTNT::NETWORK_ID;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}