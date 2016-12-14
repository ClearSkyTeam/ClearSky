<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\MainLogger;
use pocketmine\utils\UUID;
use pocketmine\item\Potion;
use pocketmine\block\Planks;
use pocketmine\block\Wood;
use pocketmine\block\Wood2;
use pocketmine\item\Fish;
use pocketmine\item\Dye;

class CraftingManager{

	/** @var Recipe[] */
	public $recipes = [];

	/** @var Recipe[][] */
	protected $recipeLookup = [];

	/** @var FurnaceRecipe[] */
	public $furnaceRecipes = [];

	private static $RECIPE_COUNT = 0;

	public function __construct(){
		$this->registerBrewingStand();
		$this->registerFurnace();
		// load recipes from src/pocketmine/resources/recipes.json
		$recipes = new Config(Server::getInstance()->getFilePath() . "src/pocketmine/resources/recipes.json", Config::JSON, []);

		MainLogger::getLogger()->info("Loading recipes...");
		foreach($recipes->getAll() as $recipe){
			switch($recipe["type"]){
				case 0:
					// TODO: handle multiple result items
					if(count($recipe["output"]) === 1){
						$first = $recipe["output"][0];
						$result = new ShapelessRecipe(Item::get($first["id"], $first["damage"], $first["count"], $first["nbt"]));

						foreach($recipe["input"] as $ingredient){
							$result->addIngredient(Item::get($ingredient["id"], $ingredient["damage"], $ingredient["count"], $first["nbt"]));
						}
						$this->registerRecipe($result);
					}
					break;
				case 1:
					// TODO: handle multiple result items
					if(count($recipe["output"]) === 1){
						$first = $recipe["output"][0];
						$result = new ShapedRecipe(Item::get($first["id"], $first["damage"], $first["count"], $first["nbt"]), $recipe["height"], $recipe["width"]);

						$shape = array_chunk($recipe["input"], $recipe["width"]);
						foreach($shape as $y => $row){
							foreach($row as $x => $ingredient){
								$result->addIngredient($x, $y, Item::get($ingredient["id"], ($ingredient["damage"] < 0 ? null : $ingredient["damage"]), $ingredient["count"], $ingredient["nbt"]));
							}
						}
						$this->registerRecipe($result);
					}
					break;
				case 2:
				case 3:
					$result = $recipe["output"];
					$resultItem = Item::get($result["id"], $result["damage"], $result["count"], $result["nbt"]);
					$this->registerRecipe(new FurnaceRecipe($resultItem, Item::get($recipe["inputId"], $recipe["inputDamage"] ?? null, 1)));
					break;
				default:
					break;
			}
		}
	}

	protected function registerFurnace(){
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::STONE, 0, 1), Item::get(Item::COBBLESTONE, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::STONE_BRICK, 2, 1), Item::get(Item::STONE_BRICK, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::GLASS, 0, 1), Item::get(Item::SAND, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::COAL, 1, 1), Item::get(Item::TRUNK, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::GOLD_INGOT, 0, 1), Item::get(Item::GOLD_ORE, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::IRON_INGOT, 0, 1), Item::get(Item::IRON_ORE, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::EMERALD, 0, 1), Item::get(Item::EMERALD_ORE, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::DIAMOND, 0, 1), Item::get(Item::DIAMOND_ORE, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::NETHER_BRICK, 0, 1), Item::get(Item::NETHERRACK, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::COOKED_PORKCHOP, 0, 1), Item::get(Item::RAW_PORKCHOP, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::BRICK, 0, 1), Item::get(Item::CLAY, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::COOKED_FISH, 0, 1), Item::get(Item::RAW_FISH, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::COOKED_SALMON, 0, 1), Item::get(Item::RAW_SALMON, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::DYE, 2, 1), Item::get(Item::CACTUS, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::DYE, 1, 1), Item::get(Item::RED_MUSHROOM, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::STEAK, 0, 1), Item::get(Item::RAW_BEEF, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::COOKED_CHICKEN, 0, 1), Item::get(Item::RAW_CHICKEN, null, 1)));
		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::BAKED_POTATO, 0, 1), Item::get(Item::POTATO, null, 1)));

		$this->registerRecipe(new FurnaceRecipe(Item::get(Item::HARDENED_CLAY, 0, 1), Item::get(Item::CLAY_BLOCK, null, 1)));
	}

	protected function registerBrewingStand(){
		//base
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::AWKWARD, 1), Item::get(Item::NETHER_WART, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE_EXTENDED, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE, 1), Item::get(Item::GHAST_TEAR, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE, 1), Item::get(Item::GLISTERING_MELON, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE, 1), Item::get(Item::BLAZE_POWDER, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE, 1), Item::get(Item::MAGMA_CREAM, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE, 1), Item::get(Item::SUGAR, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE, 1), Item::get(Item::SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::MUNDANE, 1), Item::get(Item::RABBIT_FOOT, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::THICK, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::WATER_BOTTLE, 1)));
		//secondary positive
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HEALING, 1), Item::get(Item::GLISTERING_MELON, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::FIRE_RESISTANCE, 1), Item::get(Item::MAGMA_CREAM, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::REGENERATION, 1), Item::get(Item::GHAST_TEAR, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::STRENGTH, 1), Item::get(Item::BLAZE_POWDER, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SPEED, 1), Item::get(Item::SUGAR, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::NIGHT_VISION, 1), Item::get(Item::GOLDEN_CARROT, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WATER_BREATHING, 1), Item::get(Item::RAW_FISH, Fish::PUFFERFISH, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::LEAPING, 1), Item::get(Item::RABBIT_FOOT, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		//secondary negative
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::POISON, 1), Item::get(Item::SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::AWKWARD, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::THICK, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::MUNDANE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS_T, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::MUNDANE_EXTENDED, 1)));
		//tertiary positive
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::FIRE_RESISTANCE_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::FIRE_RESISTANCE, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HEALING_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::HEALING, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::REGENERATION_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::REGENERATION, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::REGENERATION_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::REGENERATION_TWO, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::REGENERATION_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::REGENERATION, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::REGENERATION_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::REGENERATION_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::STRENGTH_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::STRENGTH, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::STRENGTH_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::STRENGTH_TWO, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::STRENGTH_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::STRENGTH, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::STRENGTH_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::STRENGTH_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SPEED_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::SPEED, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SPEED_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::SPEED_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::NIGHT_VISION_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::NIGHT_VISION, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::INVISIBILITY, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::NIGHT_VISION, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::INVISIBILITY_T, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::NIGHT_VISION_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::INVISIBILITY_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::INVISIBILITY, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WATER_BREATHING_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::WATER_BREATHING, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::LEAPING_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::LEAPING, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::LEAPING_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::LEAPING_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::LEAPING_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::LEAPING, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::LEAPING_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::LEAPING_TWO, 1)));
		//tertiary negative
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HARMING, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::HEALING, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HARMING, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::POISON, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HARMING, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::POISON_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HARMING_TWO, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::HEALING_TWO, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HARMING_TWO, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::POISON_TWO, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HARMING_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::HARMING, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::POISON_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::POISON, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::POISON_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::POISON_TWO, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::POISON_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::POISON, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::POISON_TWO, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::POISON_T, 1)));
		//$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::FIRE_RESISTANCE, 1))); // removed?
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::SPEED, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::LEAPING, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::SLOWNESS, 1)));
		//$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS_T, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::FIRE_RESISTANCE_T, 1))); // removed?
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS_T, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::SPEED_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS_T, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::LEAPING_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::STRENGTH, 1)));
		//$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::REGENERATION, 1))); // removed?
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::STRENGTH, 1)));
		//$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS_T, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::REGENERATION_T, 1))); // removed?
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS_T, 1), Item::get(Item::FERMENTED_SPIDER_EYE, 0, 1), Item::get(Item::POTION, Potion::STRENGTH_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS_T, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::WEAKNESS, 1)));
		//reverted
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::FIRE_RESISTANCE, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::FIRE_RESISTANCE_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::NIGHT_VISION, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::NIGHT_VISION_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::SLOWNESS, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::SLOWNESS_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WEAKNESS, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::WEAKNESS_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::WATER_BREATHING, 1), Item::get(Item::GLOWSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::WATER_BREATHING_T, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HEALING, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::HEALING_TWO, 1)));
		$this->registerRecipe(new BrewingRecipe(Item::get(Item::POTION, Potion::HARMING, 1), Item::get(Item::REDSTONE_DUST, 0, 1), Item::get(Item::POTION, Potion::HARMING_TWO, 1)));
	}

	public function sort(Item $i1, Item $i2){
		if($i1->getId() > $i2->getId()){
			return 1;
		}elseif($i1->getId() < $i2->getId()){
			return -1;
		}elseif($i1->getDamage() > $i2->getDamage()){
			return 1;
		}elseif($i1->getDamage() < $i2->getDamage()){
			return -1;
		}elseif($i1->getCount() > $i2->getCount()){
			return 1;
		}elseif($i1->getCount() < $i2->getCount()){
			return -1;
		}else{
			return 0;
		}
	}

	/**
	 * @param UUID $id
	 * @return Recipe
	 */
	public function getRecipe(UUID $id){
		$index = $id->toBinary();
		return isset($this->recipes[$index]) ? $this->recipes[$index] : null;
	}

	/**
	 * @return Recipe[]
	 */
	public function getRecipes(){
		return $this->recipes;
	}

	/**
	 * @return FurnaceRecipe[]
	 */
	public function getFurnaceRecipes(){
		return $this->furnaceRecipes;
	}

	/**
	 * @param Item $input
	 *
	 * @return FurnaceRecipe
	 */
	public function matchFurnaceRecipe(Item $input){
		$subscript1 = $input->getId() . ":" . $input->getDamage();
		$subscript2 = $input->getId() . ":?";
		return $this->furnaceRecipes[$subscript1]??$this->furnaceRecipes[$subscript2]??null;
	}

	/**
	 * @param Item $input
	 * 
	 * @return BrewingRecipe
	 */
 	public function matchBrewingRecipe(Item $input, Item $potion){
		$subscript = $input->getId() . ":" . ($input->getDamage() === null ? "0" : $input->getDamage()) . ":" . $potion->getId() . ":" .($potion->getDamage() === null ? "0" : $potion->getDamage());
		return $this->brewingRecipes[$subscript] ?? null;
  	}

	/**
	 * @param ShapedRecipe $recipe
	 */
	public function registerShapedRecipe(ShapedRecipe $recipe){
		$result = $recipe->getResult();
		$this->recipes[$recipe->getId()->toBinary()] = $recipe;
		$ingredients = $recipe->getIngredientMap();
		$hash = "";
		foreach($ingredients as $v){
			foreach($v as $item){
				if($item !== null){
					/** @var Item $item */
					$hash .= $item->getId() . ":" . ($item->getDamage() === null ? "?" : $item->getDamage()) . "x" . $item->getCount() . ",";
				}
			}

			$hash .= ";";
		}

		$this->recipeLookup[$result->getId() . ":" . $result->getDamage()][$hash] = $recipe;
	}

	/**
	 * @param ShapelessRecipe $recipe
	 */
	public function registerShapelessRecipe(ShapelessRecipe $recipe){
		$result = $recipe->getResult();
		$this->recipes[$recipe->getId()->toBinary()] = $recipe;
		$hash = "";
		$ingredients = $recipe->getIngredientList();
		usort($ingredients, [$this, "sort"]);
		foreach($ingredients as $item){
			$hash .= $item->getId() . ":" . ($item->getDamage() === null ? "?" : $item->getDamage()) . "x" . $item->getCount() . ",";
		}
		$this->recipeLookup[$result->getId() . ":" . $result->getDamage()][$hash] = $recipe;
	}

	/**
	 * @param FurnaceRecipe $recipe
	 */
	public function registerFurnaceRecipe(FurnaceRecipe $recipe){
		$input = $recipe->getInput();
		$this->furnaceRecipes[$input->getId() . ":" . ($input->getDamage() === null ? "?" : $input->getDamage())] = $recipe;
	}

	/**
	 * @param BrewingRecipe $recipe
	 */
	public function registerBrewingRecipe(BrewingRecipe $recipe){
		$input = $recipe->getInput();
		$potion = $recipe->getPotion();
		$this->brewingRecipes[$input->getId() . ":" . ($input->getDamage() === null ? "0" : $input->getDamage()) . ":" . $potion->getId() . ":" .($potion->getDamage() === null ? "0" : $potion->getDamage())] = $recipe;
	}

	/**
	 * @param ShapelessRecipe $recipe
	 * @return bool
	 */
	public function matchRecipe(ShapelessRecipe $recipe){
		if(!isset($this->recipeLookup[$idx = $recipe->getResult()->getId() . ":" . $recipe->getResult()->getDamage()])){
			return false;
		}

		$hash = "";
		$ingredients = $recipe->getIngredientList();
		usort($ingredients, [$this, "sort"]);
		foreach($ingredients as $item){
			$hash .= $item->getId() . ":" . ($item->getDamage() === null ? "?" : $item->getDamage()) . "x" . $item->getCount() . ",";
		}

		if(isset($this->recipeLookup[$idx][$hash])){
			return true;
		}

		$hasRecipe = null;
		foreach($this->recipeLookup[$idx] as $recipe){
			if($recipe instanceof ShapelessRecipe){
				if($recipe->getIngredientCount() !== count($ingredients)){
					continue;
				}
				$checkInput = $recipe->getIngredientList();
				foreach($ingredients as $item){
					$amount = $item->getCount();
					foreach($checkInput as $k => $checkItem){
						if($checkItem->equals($item, $checkItem->getDamage() === null ? false : true, $checkItem->getCompoundTag() === null ? false : true)){
							$remove = min($checkItem->getCount(), $amount);
							$checkItem->setCount($checkItem->getCount() - $remove);
							if($checkItem->getCount() === 0){
								unset($checkInput[$k]);
							}
							$amount -= $remove;
							if($amount === 0){
								break;
							}
						}
					}
				}

				if(count($checkInput) === 0){
					$hasRecipe = $recipe;
					break;
				}
			}
			if($hasRecipe instanceof Recipe){
				break;
			}
		}

		return $hasRecipe !== null;

	}

	/**
	 * @param Recipe $recipe
	 */
	public function registerRecipe(Recipe $recipe){
		$recipe->setId(UUID::fromData(++self::$RECIPE_COUNT, $recipe->getResult()->getId(), $recipe->getResult()->getDamage(), $recipe->getResult()->getCount(), $recipe->getResult()->getCompoundTag()));

		if($recipe instanceof ShapedRecipe){
			$this->registerShapedRecipe($recipe);
		}elseif($recipe instanceof ShapelessRecipe){
			$this->registerShapelessRecipe($recipe);
		}elseif($recipe instanceof FurnaceRecipe){
			$this->registerFurnaceRecipe($recipe);
		}elseif($recipe instanceof BrewingRecipe){
			$this->registerBrewingRecipe($recipe);
		}
	}

}