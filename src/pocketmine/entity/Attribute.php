<?php
namespace pocketmine\entity;

use pocketmine\network\protocol\UpdateAttributePacket;
use pocketmine\Player;
use pocketmine\entity\AttributeManager;

class Attribute{
	const MAX_HEALTH = 0;
	const MAX_HUNGER = 1;
    
	const EXPERIENCE = 2;
	const EXPERIENCE_LEVEL = 3;
	private $id;
	protected $minValue;
	protected $maxValue;
	protected $defaultValue;
	protected $currentValue;
	protected $name;
	protected $shouldSend;
        
        /** @var Player */
        protected $player;
	protected static $attributes = [];
	public static function init(){
		self::addAttribute(AttributeManager::MAX_HEALTH, "generic.health", 0, 20, 20, true);
		self::addAttribute(AttributeManager::MAX_HUNGER, "player.hunger", 0, 20, 20, true);
		self::addAttribute(AttributeManager::EXPERIENCE, "player.experience", 0, 1, 0, true);
		self::addAttribute(AttributeManager::EXPERIENCE_LEVEL, "player.level", 0, 24791, 0, true);
	}

	/**
	 * @param int    $id
	 * @param string $name
	 * @param float  $minValue
	 * @param float  $maxValue
	 * @param float  $defaultValue
	 * @param bool   $shouldSend
	 *
	 * @return Attribute
	 */
	public static function addAttribute($id, $name, $minValue, $maxValue, $defaultValue, $shouldSend = true){
		if($minValue > $maxValue or $defaultValue > $maxValue or $defaultValue < $minValue){
			throw new \InvalidArgumentException("Invalid ranges: min value: $minValue, max value: $maxValue, $defaultValue: $defaultValue");
		}
		return self::$attributes[(int) $id] = new Attribute($id, $name, $minValue, $maxValue, $defaultValue, $shouldSend);
	}

	/**
	 * @param $id
	 *
	 * @return null|Attribute
	 */
	public static function getAttribute($id){
		return isset(self::$attributes[$id]) ? clone self::$attributes[$id] : null;
	}

	/**
	 * @param $name
	 *
	 * @return null|Attribute
	 */
	public static function getAttributeByName($name){
		foreach(self::$attributes as $a){
			if($a->getName() === $name){
				return clone $a;
			}
		}
		return null;
	}

	public function __construct($id, $name, $minValue, $maxValue, $defaultValue, $shouldSend = true){
		$this->id = (int) $id;
		$this->name = (string) $name;
		$this->minValue = (float) $minValue;
		$this->maxValue = (float) $maxValue;
		$this->defaultValue = (float) $defaultValue;
		$this->shouldSend = (bool) $shouldSend;

		$this->currentValue = $this->defaultValue;
	}

        public function getMinValue(){
            return $this->minValue;
        }

        public function setMinValue($minValue){
            if($minValue > $this->getMaxValue()){
                throw new \InvalidArgumentException("Value $minValue is bigger than the maxValue!");
            }

		if($this->minValue != $minValue){
			$this->desynchronized = true;
			$this->minValue = $minValue;
		}
		return $this;
	}

        public function getMaxValue(){
            return $this->maxValue;
        }

        public function setMaxValue($maxValue){
            if($maxValue < $this->getMinValue()){
			throw new \InvalidArgumentException("Value $maxValue is smaller than the minValue!");
            }

		if($this->maxValue != $maxValue){
			$this->desynchronized = true;
			$this->maxValue = $maxValue;
		}
		return $this;
	}

        public function getDefaultValue(){
            return $this->defaultValue;
        }

        public function setDefaultValue($defaultValue){
            if($defaultValue > $this->getMaxValue() or $defaultValue < $this->getMinValue()){
                throw new \InvalidArgumentException("Value $defaultValue exceeds the range!");
            }

		if($this->defaultValue !== $defaultValue){
			$this->desynchronized = true;
			$this->defaultValue = $defaultValue;
		}
		return $this;
	}

        public function getValue(){
            return $this->currentValue;
        }

	public function setValue($value, $fit = false){
		if($value > $this->getMaxValue() or $value < $this->getMinValue()){
			if(!$fit){
				throw new \InvalidArgumentException("Value $value exceeds the range!");
			}
			$value = min(max($value, $this->getMinValue()), $this->getMaxValue());
		}

		if($this->currentValue != $value){
			$this->desynchronized = true;
			$this->currentValue = $value;
		}
		return $this;
	}

        public function getName(){
            return $this->name;
        }

        public function getId(){
            return $this->id;
        }

        public function isSyncable(){
            return $this->shouldSend;
        }

	public function isDesynchronized() : bool{
		return $this->shouldSend and $this->desynchronized;
	}

	public function markSynchronized(bool $synced = true){
		$this->desynchronized = !$synced;
	}
}
