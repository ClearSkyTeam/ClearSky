<?php
namespace pocketmine\player;

use pocketmine\utils\UUID;

class PlayerListEntry{
	/** @var UUID */
	public $uuid;
	/** @var int */
	public $entityId;
	/** @var string */
	public $name;
	/** @var bool */
	public $skinName;
	/** @var string */
	public $skinData;
	/** @var bool */
	public $transparency;
}
