<?php
namespace pocketmine\metadata;

use pocketmine\level\Level;

class LevelMetadataStore extends MetadataStore{

	public function disambiguate(Metadatable $level, $metadataKey){
		if(!($level instanceof Level)){
			throw new \InvalidArgumentException("Argument must be a Level instance");
		}

		return strtolower($level->getName()) . ":" . $metadataKey;
	}
}