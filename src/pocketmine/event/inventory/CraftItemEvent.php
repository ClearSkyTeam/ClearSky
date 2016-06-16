<?php
namespace pocketmine\event\inventory;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\inventory\Recipe;
use pocketmine\item\Item;
use pocketmine\Player;

class CraftItemEvent extends Event implements Cancellable{
	public static $handlerList = null;

	/** @var Item[] */
	private $input = [];
	/** @var Recipe */
	private $recipe;
	/** @var \pocketmine\Player */
	private $player;


	/**
	 * @param \pocketmine\Player $player
	 * @param Item[] $input
	 * @param Recipe $recipe
	 */
	public function __construct(Player $player, array $input, Recipe $recipe){
		$this->player = $player;
		$this->input = $input;
		$this->recipe = $recipe;
	}

	/**
	 * @return Item[]
	 */
	public function getInput(){
		$items = [];
		foreach($items as $i => $item){
			$items[$i] = clone $item;
		}

		return $items;
	}

	/**
	 * @return Recipe
	 */
	public function getRecipe(){
		return $this->recipe;
	}

	/**
	 * @return \pocktemine\Player
	 */
	public function getPlayer(){
		return $this->player;
	}
}
