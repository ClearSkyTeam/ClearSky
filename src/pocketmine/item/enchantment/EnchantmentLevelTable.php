<?php

namespace pocketmine\item\enchantment;

use pocketmine\item\Armor;
use pocketmine\item\Item;

class EnchantmentLevelTable{

	private static $map = [];

	public static function init(){
		self::$map = [
			Enchantment::TYPE_ARMOR_PROTECTION => [
				Array(1, 21),
				Array(12, 32),
				Array(23, 43),
				Array(34, 54)
			],

			Enchantment::TYPE_ARMOR_FIRE_PROTECTION => [
				Array(10, 22),
				Array(18, 30),
				Array(26, 38),
				Array(34, 46)],

			Enchantment::TYPE_ARMOR_FALL_PROTECTION => [
				Array(5, 12),
				Array(11, 21),
				Array(17, 27),
				Array(23, 33)
			],

			Enchantment::TYPE_ARMOR_EXPLOSION_PROTECTION => [
				Array(5, 17),
				Array(13, 25),
				Array(21, 33),
				Array(29, 41)
			],

			Enchantment::TYPE_ARMOR_PROJECTILE_PROTECTION => [
				Array(3, 18),
				Array(9, 24),
				Array(15, 30),
				Array(21, 36)
			],

			Enchantment::TYPE_WATER_BREATHING => [
				Array(10, 40),
				Array(20, 50),
				Array(30, 60)
			],

			Enchantment::TYPE_WATER_AFFINITY => [
				Array(10, 41)
			],

			Enchantment::TYPE_ARMOR_THORNS => [
				Array(10, 60),
				Array(30, 80),
				Array(50, 100)
			],

			//Weapon
			Enchantment::TYPE_WEAPON_SHARPNESS => [
				Array(1, 21),
				Array(12, 32),
				Array(23, 43),
				Array(34, 54),
				Array(45, 65)
			],

			Enchantment::TYPE_WEAPON_SMITE => [
				Array(5, 25),
				Array(13, 33),
				Array(21, 41),
				Array(29, 49),
				Array(37, 57)
			],

			Enchantment::TYPE_WEAPON_ARTHROPODS => [
				Array(5, 25),
				Array(13, 33),
				Array(21, 41),
				Array(29, 49),
				Array(37, 57)
			],

			Enchantment::TYPE_WEAPON_KNOCKBACK => [
				Array(5, 55),
				Array(25, 75)
			],

			Enchantment::TYPE_WEAPON_FIRE_ASPECT => [
				Array(10, 60),
				Array(30, 80)
			],

			Enchantment::TYPE_WEAPON_LOOTING => [
				Array(15, 65),
				Array(24, 74),
				Array(33, 83)
			],

			//Bow
			Enchantment::TYPE_BOW_POWER => [
				Array(1, 16),
				Array(11, 26),
				Array(21, 36),
				Array(31, 46),
				Array(41, 56)
			],

			Enchantment::TYPE_BOW_KNOCKBACK => [
				Array(12, 37),
				Array(32, 57)
			],

			Enchantment::TYPE_BOW_FLAME => [
				Array(20, 50)
			],

			Enchantment::TYPE_BOW_INFINITY => [
				Array(20, 50)
			],

			//Mining
			Enchantment::TYPE_MINING_EFFICIENCY => [
				Array(1, 51),
				Array(11, 61),
				Array(21, 71),
				Array(31, 81),
				Array(41, 91)
			],

			Enchantment::TYPE_MINING_SILK_TOUCH => [
				Array(15, 65)
			],

			Enchantment::TYPE_MINING_DURABILITY => [
				Array(5, 55),
				Array(13, 63),
				Array(21, 71)
			],

			Enchantment::TYPE_MINING_FORTUNE => [
				Array(15, 55),
				Array(24, 74),
				Array(33, 83)
			],

			//Fishing
			Enchantment::TYPE_FISHING_FORTUNE => [
				Array(15, 65),
				Array(24, 74),
				Array(33, 83)
			],

			Enchantment::TYPE_FISHING_LURE => [
				Array(15, 65),
				Array(24, 74),
				Array(33, 83)
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
			$enchantmentIds = array_keys(self::$map);
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
	            if(self::isInRange($range[0], $range[1], $modifiedLevel)){
		            $result[] = $enchantment->setLevel($i);
	            }
            }
        }

        return $result;
    }
	
	public static function isInRange($min, $max, $v){
		return $v >= $min && $v <= $max;
	}

}