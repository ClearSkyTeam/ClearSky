<?php
namespace pocketmine\entity;

class AttributeMap implements \ArrayAccess{
	/** @var Attribute[] */
	private $attributes = [];

	public function addAttribute(Attribute $attribute){
		$this->attributes[$attribute->getId()] = $attribute;
	}

	/**
	 * @param int $id
	 *
	 * @return Attribute|null
	 */
	public function getAttribute(int $id){
		return $this->attributes[$id] ?? null;
	}

	/**
	 * @return Attribute[]
	 */
	public function needSend() : array{
		return array_filter($this->attributes, function (Attribute $attribute){
			return $attribute->isSyncable() and $attribute->isDesynchronized();
		});
	}

	public function offsetExists($offset){
		return isset($this->attributes[$offset]);
	}

	public function offsetGet($offset){
		return $this->attributes[$offset]->getValue();
	}

	public function offsetSet($offset, $value){
		$this->attributes[$offset]->setValue($value);
	}

	public function offsetUnset($offset){
		throw new \RuntimeException("Could not unset an attribute from an attribute map");
	}
}
