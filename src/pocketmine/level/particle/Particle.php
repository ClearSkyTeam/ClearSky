<?php
namespace pocketmine\level\particle;

use pocketmine\math\Vector3;
use pocketmine\network\protocol\DataPacket;

abstract class Particle extends Vector3{

	const TYPE_BUBBLE = 1;
	const TYPE_CRITICAL = 2;
	const TYPE_SMOKE = 3;
	const TYPE_EXPLODE = 4;
	const TYPE_WHITE_SMOKE = 5;
	const TYPE_FLAME = 6;
	const TYPE_LAVA = 7;
	const TYPE_LARGE_SMOKE = 8;
	const TYPE_REDSTONE = 9;
	const TYPE_ITEM_BREAK = 10;
	const TYPE_SNOWBALL_POOF = 11;
	const TYPE_LARGE_EXPLODE = 12;
	const TYPE_HUGE_EXPLODE = 13;
	const TYPE_MOB_FLAME = 14;
	const TYPE_HEART = 15;
	const TYPE_TERRAIN = 16;
	const TYPE_TOWN_AURA = 17;
	const TYPE_PORTAL = 18;
	const TYPE_WATER_SPLASH = 19;
	const TYPE_WATER_WAKE = 20;
	const TYPE_DRIP_WATER = 21;
	const TYPE_DRIP_LAVA = 22;
	const TYPE_DUST = 23;
	const TYPE_MOB_SPELL = 24;
	const TYPE_MOB_SPELL_AMBIENT = 25;
	const TYPE_MOB_SPELL_INSTANTANEOUS = 26;
	const TYPE_INK = 27;
	const TYPE_SLIME = 28;
	const TYPE_RAIN_SPLASH = 29;
	const TYPE_VILLAGER_ANGRY = 30;
	const TYPE_VILLAGER_HAPPY = 31;
	const TYPE_ENCHANTMENT_TABLE = 32;
	
	/**
	 * @return DataPacket|DataPacket[]
	 */
	abstract public function encode();

}
