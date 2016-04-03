<?php

namespace pocketmine\item;

use pocketmine\block\Block;

class Dye extends Item{
	const INK_SACK = 0;
	const BLACK = 0;
	const ROSE_RED = 1;
	const RED = 1;
	const CACTUS_GREEN = 2;
	const GREEN = 2;
	const COCOA_BEANS = 3;
	const BROWN = 3;
	const LAPIS_LAZULI = 4;
	const DARK_BLUE = 4;
	const PURPLE = 5;
	const CYAN = 6;
	const LIGHT_GRAY = 7;
	const GRAY = 8;
	const PINK = 9;
	const LIME = 10;
	const DANDELION_YELLOW = 11;
	const YELLOW = 11;
	const LIGHT_BLUE = 12;
	const MAGENTA = 13;
	const ORANGE = 14;
	const BONEMEAL = 15;
	const WHITE = 15;

	public function __construct($meta = 0, $count = 1){
		if($meta === self::COCOA_BEANS){
			$this->block = Block::get(Item::COCOA_POD);
		}
		parent::__construct(self::DYE, $meta, $count, $this->getNameByMeta($meta));
	}

	public function getNameByMeta($meta){
		switch($meta){
			case self::INK_SACK:
			case self::BLACK:
				return "Ink Sack";
				break;
			case self::ROSE_RED:
			case self::RED:
				return "Rose Red";
				break;
			case self::CACTUS_GREEN:
			case self::GREEN:
				return "Cactus Green";
				break;
			case self::COCOA_BEANS:
			case self::BROWN:
				return "Cocoa Beans";
				break;
			case self::LAPIS_LAZULI:
			case self::DARK_BLUE:
				return "Lapis Lazuli";
				break;
			case self::PURPLE:
				return "Purple Dye";
				break;
			case self::CYAN:
				return "Cyan Dye";
				break;
			case self::LIGHT_GRAY:
				return "Light Gray Dye";
				break;
			case self::GRAY:
				return "Gray Dye";
				break;
			case self::PINK:
				return "Pink Dye";
				break;
			case self::LIME:
				return "Lime Dye";
				break;
			case self::DANDELION_YELLOW:
			case self::YELLOW:
				return "Dandelion Yellow";
				break;
			case self::LIGHT_BLUE:
				return "Light Blue Dye";
				break;
			case self::MAGENTA:
				return "Magenta Dye";
				break;
			case self::ORANGE:
				return "Orange Dye";
				break;
			case self::BONEMEAL:
			case self::WHITE:
				return "Bonemeal";
				break;
			default:
				return "Dye";
		}
	}
}
