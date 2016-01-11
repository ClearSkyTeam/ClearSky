<?php
namespace pocketmine\block;


use pocketmine\math\AxisAlignedBB;

abstract class Thin extends Transparent{

	public function isSolid(){
		return false;
	}

	protected function recalculateBoundingBox(){

		$f = 0.4375;
		$f1 = 0.5625;
		$f2 = 0.4375;
		$f3 = 0.5625;

		$flag = $this->canConnect($this->getSide(2));
		$flag1 = $this->canConnect($this->getSide(3));
		$flag2 = $this->canConnect($this->getSide(4));
		$flag3 = $this->canConnect($this->getSide(5));

		if((!$flag2 or !$flag3) and ($flag2 or $flag3 or $flag or $flag1)){
			if($flag2 and !$flag3){
				$f = 0;
			}elseif(!$flag2 and $flag3){
				$f1 = 1;
			}
		}else{
			$f = 0;
			$f1 = 1;
		}

		if((!$flag or !$flag1) and ($flag2 or $flag3 or $flag or $flag1)){
			if($flag and !$flag1){
				$f2 = 0;
			}elseif(!$flag and $flag1){
				$f3 = 1;
			}
		}else{
			$f2 = 0;
			$f3 = 1;
		}

		return new AxisAlignedBB(
			$this->x + $f,
			$this->y,
			$this->z + $f2,
			$this->x + $f1,
			$this->y + 1,
			$this->z + $f3
		);
	}


	public function canConnect(Block $block){
		return $block->isSolid() or $block->getId() === $this->getId() or $block->getId() === self::GLASS_PANE or $block->getId() === self::GLASS;
	}

}