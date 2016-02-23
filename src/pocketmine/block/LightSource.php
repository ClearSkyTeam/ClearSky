<?php
namespace pocketmine\block;

interface LightSource{
	public function getLightLevel();
	public function isLightSource();
}
