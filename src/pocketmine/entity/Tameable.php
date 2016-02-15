<?php

namespace pocketmine\entity;

interface Tameable{
	const DATA_FLAG_TAMED = 0;

	public function isTamed();
}