<?php
namespace pocketmine\event;

class TextContainer{

	/** @var string $text */
	protected $text;

	public function __construct($text){
		$this->text = $text;
	}

	public function setText($text){
		$this->text = $text;
	}

	/**
	 * @return string
	 */
	public function getText(){
		return $this->text;
	}

	/**
	 * @return string
	 */
	public function __toString(){
		return $this->getText();
	}
}