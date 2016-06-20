<?php

/*

 *
 *  _                       _           _ __  __ _             
 * (_)                     (_)         | |  \/  (_)            
 *  _ _ __ ___   __ _  __ _ _  ___ __ _| | \  / |_ _ __   ___  
 * | | '_ ` _ \ / _` |/ _` | |/ __/ _` | | |\/| | | '_ \ / _ \ 
 * | | | | | | | (_| | (_| | | (_| (_| | | |  | | | | | |  __/ 
 * |_|_| |_| |_|\__,_|\__, |_|\___\__,_|_|_|  |_|_|_| |_|\___| 
 *                     __/ |                                   
 *                    |___/                                                                     
 * 
 * This program is a third party build by ImagicalMine.
 * 
 * PocketMine is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author ImagicalMine Team
 * @link http://forums.imagicalcorp.ml/
 * 
 *
*/

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\item\Item;
use pocketmine\Player;

/**
 * Called when a player uses the fishing rod
 */
class PlayerFishEvent extends PlayerEvent implements Cancellable{

	public static $handlerList = null;

	/** @var Item */
	private $item;

	/**
	 * @param Player $player
	 * @param Item   $item
	 * @param $fishingHook
	 */
	public function __construct(Player $player, Item $item, $fishingHook = null){
		$this->player = $player;
		$this->item = $item;
		$this->fishEntity = $fishingHook;
	}

	/**
	 * @return Item
	 */
	public function getItem(){
		return clone $this->item;
	}

	public function getfishEntity(){
		return $this->fishEntity;
	}
}
