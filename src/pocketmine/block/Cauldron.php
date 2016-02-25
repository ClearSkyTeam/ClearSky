<?php

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\item\Potion;
use pocketmine\Server;
use pocketmine\network\protocol\ExplodePacket;
use pocketmine\item\GlassBottle;
use pocketmine\item\Bucket;
use pocketmine\network\protocol\Info;
use pocketmine\network\protocol\AnimatePacket;
use pocketmine\network\protocol\InteractPacket;
use pocketmine\network\protocol\PlayerActionPacket;

class Cauldron extends Transparent{
	protected $id = self::CAULDRON_BLOCK;
	protected $potion = false;
	protected $water = false;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeActivated(){
		return true;
	}

	public function getHardness(){
		return 2;
	}

	public function getName(){
		return "Cauldron";
	}

	public function onActivate(Item $item, Player $player = null){
		$item = $player->getInventory()->getItemInHand();
		$success = false;
		if($item instanceof Potion){
			if($this->potion === null || $this->potion === false){
				$this->potion = $item->getId();
				$this->meta = 1;
				$success = true;
			}
			elseif($this->potion === $item->getId()){
				if($this->meta < 3){
					++$this->meta;
					$success = true;
				}
			}
			elseif($this->potion !== $item->getId()){
				$this->meta = 0;
				$pk = new ExplodePacket();
				$pk->x = $this->x + 0.5;
				$pk->y = $this->y + 0.5;
				$pk->z = $this->z + 0.5;
				$pk->radius = 1;
				$pk->records = [$this->add(0.5, 0.5, 0.5)];
				Server::broadcastPacket($this->getLevel()->getPlayers(), $pk);
				$success = true;
			}
		}
		elseif($item instanceof GlassBottle){
			--$this->meta;
			if($this->water === true && $this->meta === 0){
				$this->water = false;
			}
			$player->getInventory()->removeItem(Item::get($item->getId()));
			$player->getInventory()->addItem(Item::get(Item::POTION, 1, $this->potion));
			$success = true;
		}
		elseif($item instanceof Bucket && $item->getDamage() === Block::WATER){
			$this->meta = 3;
			$this->potion = 0;
			$this->water = true;
			$player->getInventory()->removeItem(Item::get($item->getId()));
			$player->getInventory()->addItem(Item::get(Item::BUCKET));
			$success = true;
		}
		elseif($item instanceof Bucket && $item->getDamage() === Block::AIR && $this->water === true){
			$full = ($this->meta >= 3);
			$this->meta = 0;
			$this->potion = false;
			$this->water = false;
			if($full){
				$player->getInventory()->removeItem(Item::get($item->getId()));
				$player->getInventory()->addItem(Item::get(Item::BUCKET, Block::WATER, 1));
			}
			$success = true;
		}
		if($success){
			$this->getLevel()->setBlock($this, $this, true);
		}
		//TODO: Bubbles
		return $success;
	}
}