<?php
namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\entity\Entity;

class NetherPortal extends Flowable{
	protected $id = self::NETHER_PORTAL;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 15;
	}

	public function getName(){
		return "Nether Portal";
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$this->getLevel()->setBlock($block, $this, true, true);
		return false;
	}

	public function getDrops(Item $item){
		return;
	}
	
	public function onEntityCollide(Entity $entity){
        //Server::getInstance()->getPluginManager()->callEvent($ev = new EntityEnterPortalEvent($this, $entity));
        //if(!$ev->isCancelled()) {
            //TODO: Delayed teleport entity to nether world.
        //}
        return true;
    }
    
   	public function canPassThrough(){
		return true;
	}
}
