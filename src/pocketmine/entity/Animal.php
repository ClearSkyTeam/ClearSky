<?php
namespace pocketmine\entity;

abstract class Animal extends Creature implements Ageable{

	public function initEntity(){
		parent::initEntity();
		if($this->getDataProperty(self::DATA_AGEABLE_FLAGS) === null){
			$this->setDataProperty(self::DATA_AGEABLE_FLAGS, self::DATA_TYPE_BYTE, 0);
		}
	}

	public function isBaby(){
		return $this->getDataFlag(self::DATA_AGEABLE_FLAGS, self::DATA_FLAG_BABY);
	}
	
	public function isLeashableType(){
		return true;
	}
}