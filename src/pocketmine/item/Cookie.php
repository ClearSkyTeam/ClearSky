<?php
namespace pocketmine\item;

class Cookie extends Food{
	public $saturation = 2;

	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::COOKIE, $meta, $count, "Cookie");
	}
}