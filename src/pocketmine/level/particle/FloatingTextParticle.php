<?php
namespace pocketmine\level\particle;

use pocketmine\entity\Entity;
use pocketmine\entity\Item as ItemEntity;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\AddPlayerPacket;
use pocketmine\network\protocol\RemoveEntityPacket;
use pocketmine\utils\UUID;

class FloatingTextParticle extends Particle{
	//TODO: HACK!

	protected $text;
	protected $title;
	protected $entityId;
	protected $invisible = false;

	/**
	 * @param Vector3 $pos
	 * @param int $text
	 * @param string $title
	 */
	public function __construct(Vector3 $pos, $text, $title = ""){
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->text = $text;
		$this->title = $title;
	}

	public function setText($text){
		$this->text = $text;
	}

	public function setTitle($title){
		$this->title = $title;
	}
	
	public function isInvisible(){
		return $this->invisible;
	}
	
	public function setInvisible($value = true){
		$this->invisible = (bool) $value;
	}

	public function encode(){
		$p = [];

		if($this->entityId === null){
			$this->entityId = bcadd("1095216660480", mt_rand(0, 0x7fffffff)); //No conflict with other things
		}else{
			$pk0 = new RemoveEntityPacket();
			$pk0->eid = $this->entityId;

			$p[] = $pk0;
		}

		if(!$this->invisible){
			
			$pk = new AddPlayerPacket();
			$pk->eid = $this->entityId;
			$pk->uuid = UUID::fromRandom();
			$pk->x = $this->x;
			$pk->y = $this->y - 0.75;
			$pk->z = $this->z;
			$pk->speedX = 0;
			$pk->speedY = 0;
			$pk->speedZ = 0;
			$pk->yaw = 0;
			$pk->pitch = 0;
			$pk->meta = 0;
			$pk->metadata = [
				Entity::DATA_FLAGS => [Entity::DATA_TYPE_BYTE, 1 << Entity::DATA_FLAG_INVISIBLE],
				Entity::DATA_NAMETAG => [Entity::DATA_TYPE_STRING, $this->title . ($this->text !== "" ? "\n" . $this->text : "")],
				Entity::DATA_SHOW_NAMETAG => [Entity::DATA_TYPE_BYTE, 1],
				Entity::DATA_NO_AI => [Entity::DATA_TYPE_BYTE, 1]
 				Entity::DATA_LEAD_HOLDER => [Entity::DATA_TYPE_LONG, -1],
 				Entity::DATA_LEAD => [Entity::DATA_TYPE_BYTE, 0]
            ];

			$p[] = $pk;
		}
		
		return $p;
	}
}
