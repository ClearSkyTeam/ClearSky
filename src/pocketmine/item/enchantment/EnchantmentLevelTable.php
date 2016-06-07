<?php

namespace pocketmine\item\enchantment;

use pocketmine\item\Armor;
use pocketmine\item\Item;

class EnchantmentLevelTable{

	private static $map = [];

	public static function init(){
		self::$map = [
			Enchantment::TYPE_ARMOR_PROTECTION => [
				new Array(1, 21),
				new Array(12, 32),
				new Array(23, 43),
				new Array(34, 54)
			],

			Enchantment::TYPE_ARMOR_FIRE_PROTECTION => [
				new Array(10, 22),
				new Array(18, 30),
				new Array(26, 38),
				new Array(34, 46)],

			Enchantment::TYPE_ARMOR_FALL_PROTECTION => [
				new Array(5, 12),
				new Array(11, 21),
				new Array(17, 27),
				new Array(23, 33)
			],

			Enchantment::TYPE_ARMOR_EXPLOSION_PROTECTION => [
				new Array(5, 17),
				new Array(13, 25),
				new Array(21, 33),
				new Array(29, 41)
			],

			Enchantment::TYPE_ARMOR_PROJECTILE_PROTECTION => [
				new Array(3, 18),
				new Array(9, 24),
				new Array(15, 30),
				new Array(21, 36)
			],

			Enchantment::TYPE_WATER_BREATHING => [
				new Array(10, 40),
				new Array(20, 50),
				new Array(30, 60)
			],

			Enchantment::TYPE_WATER_AFFINITY => [
				new Array(10, 41)
			],

			Enchantment::TYPE_ARMOR_THORNS => [
				new Array(10, 60),
				new Array(30, 80),
				new Array(50, 100)
			],

			//Weapon
			Enchantment::TYPE_WEAPON_SHARPNESS => [
				new Array(1, 21),
				new Array(12, 32),
				new Array(23, 43),
				new Array(34, 54),
				new Array(45, 65)
			],

			Enchantment::TYPE_WEAPON_SMITE => [
				new Array(5, 25),
				new Array(13, 33),
				new Array(21, 41),
				new Array(29, 49),
				new Array(37, 57)
			],

			Enchantment::TYPE_WEAPON_ARTHROPODS => [
				new Array(5, 25),
				new Array(13, 33),
				new Array(21, 41),
				new Array(29, 49),
				new Array(37, 57)
			],

			Enchantment::TYPE_WEAPON_KNOCKBACK => [
				new Array(5, 55),
				new Array(25, 75)
			],

			Enchantment::TYPE_WEAPON_FIRE_ASPECT => [
				new Array(10, 60),
				new Array(30, 80)
			],

			Enchantment::TYPE_WEAPON_LOOTING => [
				new Array(15, 65),
				new Array(24, 74),
				new Array(33, 83)
			],

			//Bow
			Enchantment::TYPE_BOW_POWER => [
				new Array(1, 16),
				new Array(11, 26),
				new Array(21, 36),
				new Array(31, 46),
				new Array(41, 56)
			],

			Enchantment::TYPE_BOW_KNOCKBACK => [
				new Array(12, 37),
				new Array(32, 57)
			],

			Enchantment::TYPE_BOW_FLAME => [
				new Array(20, 50)
			],

			Enchantment::TYPE_BOW_INFINITY => [
				new Array(20, 50)
			],

			//Mining
			Enchantment::TYPE_MINING_EFFICIENCY => [
				new Array(1, 51),
				new Array(11, 61),
				new Array(21, 71),
				new Array(31, 81),
				new Array(41, 91)
			],

			Enchantment::TYPE_MINING_SILK_TOUCH => [
				new Array(15, 65)
			],

			Enchantment::TYPE_MINING_DURABILITY => [
				new Array(5, 55),
				new Array(13, 63),
				new Array(21, 71)
			],

			Enchantment::TYPE_MINING_FORTUNE => [
				new Array(15, 55),
				new Array(24, 74),
				new Array(33, 83)
			],

			//Fishing
			Enchantment::TYPE_FISHING_FORTUNE => [
				new Array(15, 65),
				new Array(24, 74),
				new Array(33, 83)
			],

			Enchantment::TYPE_FISHING_LURE => [
				new Array(15, 65),
				new Array(24, 74),
				new Array(33, 83)
			]
		];
	}

	/**
	 * @param Item $item
	 * @param int  $modifiedLevel
	 * @return Enchantment[]
	 */
	public static function getPossibleEnchantments(Item $item, int $modifiedLevel){
		$result = [];

		$enchantmentIds = [];

		if($item->getId() == Item::BOOK){
			$enchantmentIds = self::$map;
		}elseif($item->isArmor()){
			$enchantmentIds[] = Enchantment::TYPE_ARMOR_PROTECTION; 
			$enchantmentIds[] = Enchantment::TYPE_ARMOR_FIRE_PROTECTION; 
			$enchantmentIds[] = Enchantment::TYPE_ARMOR_EXPLOSION_PROTECTION; 
			$enchantmentIds[] = Enchantment::TYPE_ARMOR_PROJECTILE_PROTECTION; 
			$enchantmentIds[] = Enchantment::TYPE_ARMOR_THORNS; 

			if($item->isBoots()){
				$enchantmentIds[] = Enchantment::TYPE_ARMOR_FALL_PROTECTION; 
			}

			if($item->isHelmet()){
				$enchantmentIds[] = Enchantment::TYPE_WATER_BREATHING; 
				$enchantmentIds[] = Enchantment::TYPE_WATER_AFFINITY; 
			}

		}elseif($item->isSword()){
			$enchantmentIds[] = Enchantment::TYPE_WEAPON_SHARPNESS; 
			$enchantmentIds[] = Enchantment::TYPE_WEAPON_SMITE; 
			$enchantmentIds[] = Enchantment::TYPE_WEAPON_ARTHROPODS; 
			$enchantmentIds[] = Enchantment::TYPE_WEAPON_KNOCKBACK; 
			$enchantmentIds[] = Enchantment::TYPE_WEAPON_FIRE_ASPECT; 
			$enchantmentIds[] = Enchantment::TYPE_WEAPON_LOOTING; 

		}elseif($item->isTool()){
			$enchantmentIds[] = Enchantment::TYPE_MINING_EFFICIENCY; 
			$enchantmentIds[] = Enchantment::TYPE_MINING_SILK_TOUCH; 
			$enchantmentIds[] = Enchantment::TYPE_MINING_FORTUNE; 

		}elseif($item->getId() == Item::BOW){
			$enchantmentIds[] = Enchantment::TYPE_BOW_POWER; 
			$enchantmentIds[] = Enchantment::TYPE_BOW_KNOCKBACK; 
			$enchantmentIds[] = Enchantment::TYPE_BOW_FLAME; 
			$enchantmentIds[] = Enchantment::TYPE_BOW_INFINITY; 

		}elseif($item->getId() == Item::FISHING_ROD){
			$enchantmentIds[] = Enchantment::TYPE_FISHING_FORTUNE; 
			$enchantmentIds[] = Enchantment::TYPE_FISHING_LURE; 

		}

		if($item->isTool() || $item->isArmor()){
			$enchantmentIds[] = Enchantment::TYPE_MINING_DURABILITY; 
		}

		foreach($enchantmentIds as $enchantmentId) {
			$enchantment = Enchantment::getEnchantment($enchantmentId);
            $ranges = self::$map[$enchantmentId];
            $i = 0;
			/** @var Range $range */
			foreach($ranges as $range) {
	            $i++;
	            if($this->isInRange($range[0], $range[1], $modifiedLevel)){
		            $result[] = $enchantment->setLevel($i);
	            }
            }
        }

        return $result;
    }
	
	public function isInRange($min, $max, $v){
		return $v >= $min && $v <= $max;
	}

}