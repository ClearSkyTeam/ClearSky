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

namespace pocketmine\network\protocol;

use pocketmine\Server;

class LevelSoundEventPacket extends DataPacket{
	const NETWORK_ID = Info::LEVEL_SOUND_EVENT_PACKET;
	private static $sounds = null;

	public $sound;
	public $x;
	public $y;
	public $z;
	public $volume;
	public $pitch;
	public $unknownBool;
	public $unknownBool2;

	public function decode(){
		$this->sound = $this->getByte();
		$this->getVector3f($this->x, $this->y, $this->z);
		$this->volume = $this->getVarInt();
		$this->pitch = $this->getVarInt();
		$this->unknownBool = $this->getBool();
		$this->unknownBool2 = $this->getBool();
		print $this->sound;
		print $this->unknownBool;
		print $this->unknownBool2;
	}

	public function encode(){
		$this->reset();
		$this->putByte($this->sound);
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putVarInt($this->volume);
		$this->putVarInt($this->pitch);
		$this->putBool($this->unknownBool);
		$this->putBool($this->unknownBool2);
	}

	public static function getSounds() : \stdClass{
		if(self::$sounds === null){
		/* Client side sounds? */
			#self::$sounds = json_decode(file_get_contents(Server::getInstance()->getFilePath() . "src/pocketmine/resources/sounds.json"));#
			self::$sounds = json_decode(file_get_contents(Server::getInstance()->getFilePath() . "src/pocketmine/resources/clientsidedsounds.json"));
		}
		return clone self::$sounds;
	}

	public static function getSound($name){
		if(!empty($name) && @self::getSounds()->{$name} !== null){
			return $name;
		}
		return false;
	}
}