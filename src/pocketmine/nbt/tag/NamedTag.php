<?php
namespace pocketmine\nbt\tag;


abstract class NamedTag extends Tag{

	protected $__name;

	/**
	 * @param string                                                      $name
	 * @param bool|float|double|int|byte|short|array|Compound|Enum|string $value
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
	
	public function __destruct(){
		foreach (get_class_vars(__CLASS__) as $clsVar => $_){
			unset($this->$clsVar);
		}
	}
}