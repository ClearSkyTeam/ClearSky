<?php
namespace pocketmine\nbt\tag;


abstract class NamedTag extends Tag{

	protected $__name;

	/**
	 * @param string                                                      $name
	 * @param bool|float|double|int|byte|short|array|CompoundTag|EnumTag|string $value
	 */
	public function __construct($name = "", $value = null){
		$this->__name = ($name === null or $name === false) ? "" : $name;
		if($value !== null){
			$this->value = $value;
		}
	}

	public function getName(){
		return $this->__name;
	}

	public function setName($name){
		$this->__name = $name;
	}
}