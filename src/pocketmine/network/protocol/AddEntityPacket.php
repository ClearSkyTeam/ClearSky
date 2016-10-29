<?php
namespace pocketmine\network\protocol;

use pocketmine\utils\Binary;
use pocketmine\entity\Entity;

class AddEntityPacket extends DataPacket{
	const NETWORK_ID = Info::ADD_ENTITY_PACKET;

	public $eid;
	public $type;
	public $x;
	public $y;
	public $z;
	public $speedX;
	public $speedY;
	public $speedZ;
	public $yaw;
	public $pitch;
	public $metadata = [Entity::DATA_LEAD_HOLDER => [Entity::DATA_TYPE_LONG, -1], Entity::DATA_LEAD => [Entity::DATA_TYPE_BYTE, 0]];
	public $links = [];

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid); //EntityUniqueID - TODO: verify this
		$this->putEntityId($this->eid);
		$this->putUnsignedVarInt($this->type);
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putVector3f($this->speedX, $this->speedY, $this->speedZ);
		$this->putLFloat($this->yaw * (256 / 360));
		$this->putLFloat($this->pitch * (256 / 360));
		$this->putUnsignedVarInt($this->modifiers); //attributes?
		$meta = Binary::writeMetadata($this->metadata);
		$this->put($meta);
		$this->putUnsignedVarInt(count($this->links));
		foreach($this->links as $link){
			$this->putEntityId($link[0]);
			$this->putEntityId($link[1]);
			$this->putByte($link[2]);
		}
	}
}
