<?php
namespace pocketmine\inventory;

use pocketmine\item\Item;

//TODO: remove this
abstract class Fuel{
	public static $duration = [
		Item::COAL => 1600,
		Item::COAL_BLOCK => 16000,
		Item::TRUNK => 300,
		Item::BROWN_MUSHROOM_BLOCK => 300,
		Item::RED_MUSHROOM_BLOCK => 300,
		Item::WOODEN_PLANKS => 300,
		Item::SAPLING => 100,
		Item::WOODEN_AXE => 200,
		Item::WOODEN_PICKAXE => 200,
		Item::WOODEN_SWORD => 200,
		Item::WOODEN_SHOVEL => 200,
		Item::WOODEN_HOE => 200,
		Item::WOODEN_PRESSURE_PLATE => 300,
		Item::STICK => 100,
		Item::FENCE => 300,
		Item::FENCE_GATE => 300,
		Item::FENCE_GATE_SPRUCE => 300,
		Item::FENCE_GATE_BIRCH => 300,
		Item::FENCE_GATE_JUNGLE => 300,
		Item::FENCE_GATE_ACACIA => 300,
		Item::FENCE_GATE_DARK_OAK => 300,
		Item::WOODEN_STAIRS => 300,
		Item::SPRUCE_WOOD_STAIRS => 300,
		Item::BIRCH_WOOD_STAIRS => 300,
		Item::JUNGLE_WOOD_STAIRS => 300,
		Item::TRAPDOOR => 300,
		Item::WORKBENCH => 300,
		Item::NOTEBLOCK => 300,
		Item::BOOKSHELF => 300,
		Item::CHEST => 300,
		Item::TRAPPED_CHEST => 300,
		Item::DAYLIGHT_DETECTOR => 300,
		Item::BUCKET => 20000,
		Item::BLAZE_ROD => 2400,
	];

}