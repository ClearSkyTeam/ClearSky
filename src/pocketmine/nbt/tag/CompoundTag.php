<?php
namespace pocketmine\nbt\tag;

use pocketmine\nbt\NBT;

#include <rules/NBT.h>

class CompoundTag extends NamedTag implements \ArrayAccess{

	/**
	 * @param string     $name
	 * @param NamedTag[] $value
	 */
	public function __construct($name = "", $value = []){
		$this->__name = $name;
		foreach($value as $tag){
			$this->{$tag->getName()} = $tag;
		}
	}

	public function getCount(){
		$count = 0;
		foreach($this as $tag){
			if($tag instanceof Tag){
				++$count;
			}
		}

		return $count;
	}

	public function offsetExists($offset){
		return isset($this->{$offset}) and $this->{$offset} instanceof Tag;
	}

	public function offsetGet($offset){
		if(isset($this->{$offset}) and $this->{$offset} instanceof Tag){
			if($this->{$offset} instanceof \ArrayAccess){
				return $this->{$offset};
			}else{
				return $this->{$offset}->getValue();
			}
		}

		assert(false, "Offset $offset not found");
		return null;
	}

	public function offsetSet($offset, $value){
		if($value instanceof Tag){
			$this->{$offset} = $value;
		}elseif(isset($this->{$offset}) and $this->{$offset} instanceof Tag){
			$this->{$offset}->setValue($value);
		}
	}

	public function offsetUnset($offset){
		unset($this->{$offset});
	}

	public function getType(){
		return NBT::TAG_Compound;
	}

	public function read(NBT $nbt){
		$this->value = [];
		do{
			$tag = $nbt->readTag();
			if($tag instanceof NamedTag and $tag->getName() !== ""){
				$this->{$tag->getName()} = $tag;
			}
		}while(!($tag instanceof EndTag) and !$nbt->feof());
	}

	public function write(NBT $nbt){
		foreach($this as $tag){
			if($tag instanceof Tag and !($tag instanceof EndTag)){
				$nbt->writeTag($tag);
			}
		}
		$nbt->writeTag(new EndTag);
	}

	public function __toString(){
		$str = get_class($this) . "{\n";
		foreach($this as $tag){
			if($tag instanceof Tag){
				$str .= get_class($tag) . ":" . $tag->__toString() . "\n";
			}
		}
		return $str . "}";
	}
}