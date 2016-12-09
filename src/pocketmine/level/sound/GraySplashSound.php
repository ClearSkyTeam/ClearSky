<?php
namespace pocketmine\level\sound;

use pocketmine\level\sound\GenericSound;
use pocketmine\math\Vector3;
use pocketmine\network\protocol\LevelEventPacket;

class GraySplashSound extends GenericSound {

	public function __construct(Vector3 $pos, $pitch = 0){
		parent::__construct($pos, LevelEventPacket::EVENT_SOUND_GRAY_SPLASH, $pitch);
	}
}