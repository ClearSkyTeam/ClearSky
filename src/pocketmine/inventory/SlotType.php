<?php
namespace pocketmine\inventory;

/**
 * Saves all the information regarding default inventory sizes and types
 */
interface SlotType{
	const RESULT = 0;

	const CRAFTING = 1; //Not used in Minecraft: PE yet

	const ARMOR = 2;

	const CONTAINER = 3;

	const HOTBAR = 4;

	const FUEL = 5;
}