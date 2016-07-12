<?php

namespace pocketmine\item\enchantment;


class EnchantmentEntry{

	/** @var Enchantment[] */
	private $enchantments;
	private $cost;
	private $randomName;

	/**
	 * @param Enchantment[] $enchantments
	 * @param number        $cost
	 * @param string        $randomName
	 */
	public function __construct(array $enchantments, $cost){
		$this->enchantments = $enchantments;
		$this->cost = (int) $cost;
	}

	public function getEnchantments(){
		return $this->enchantments;
	}

	public function getCost(){
		return $this->cost;
	}
}