<?php
namespace pocketmine\level;

use pocketmine\math\Vector3;
use pocketmine\utils\LevelException;

class Position extends Vector3{
	/** @var Level */
	public $level = null;

	/**
	 * @param int   $x
	 * @param int   $y
	 * @param int   $z
	 * @param Level $level
	 */
	public function __construct($x = 0, $y = 0, $z = 0, Level $level = null){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		$this->level = $level;
	}

	public static function fromObject(Vector3 $pos, Level $level = null){
		return new Position($pos->x, $pos->y, $pos->z, $level);
	}
	
	public function add($x, $y = 0, $z = 0){
		if($x instanceof Vector3){
			return new Position($this->x + $x->x, $this->y + $x->y, $this->z + $x->z, $this->level);
		}else{
			return new Position($this->x + $x, $this->y + $y, $this->z + $z, $this->level);
		}
	}

	/**
	 * @return Level
	 */
	public function getLevel(){
		return $this->level;
	}

	public function setLevel(Level $level){
		$this->level = $level;
		return $this;
	}

	/**
	 * Checks if this object has a valid reference to a Level
	 *
	 * @return bool
	 */
	public function isValid(){
		return $this->level !== null;
	}

	/**
	 * Marks the level reference as strong so it won't be collected
	 * by the garbage collector.
	 *
	 * @deprecated
	 *
	 * @return bool
	 */
	public function setStrong(){
		return false;
	}

	/**
	 * Marks the level reference as weak so it won't have effect against
	 * the garbage collector decision.
	 *
	 * @deprecated
	 *
	 * @return bool
	 */
	public function setWeak(){
		return false;
	}

	/**
	 * Returns a side Vector
	 *
	 * @param int $side
	 * @param int $step
	 *
	 * @return Position
	 *
	 * @throws LevelException
	 */
	public function getSide($side, $step = 1){
		if(!$this->isValid()){
			throw new LevelException("Undefined Level reference");
		}

		return Position::fromObject(parent::getSide($side, $step), $this->level);
	}

	public function __toString(){
		return "Position(level=" . ($this->isValid() ? $this->getLevel()->getName() : "null") . ",x=" . $this->x . ",y=" . $this->y . ",z=" . $this->z . ")";
	}

	/**
	 * @param $x
	 * @param $y
	 * @param $z
	 *
	 * @return Position
	 */
	public function setComponents($x, $y, $z){
		$this->x = $x;
		$this->y = $y;
		$this->z = $z;
		return $this;
	}
	
	public function __destruct(){
		foreach (get_class_vars(__CLASS__) as $clsVar => $_) {
			unset($this->$clsVar);
		}
	}
	
}
