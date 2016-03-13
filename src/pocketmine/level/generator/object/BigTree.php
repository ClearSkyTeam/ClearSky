<?php
namespace pocketmine\level\generator\object;

use pocketmine\level\ChunkManager;

class BigTree extends Tree{
	private $trunkHeightMultiplier = 0.618;
	private $trunkHeight;
	private $leafAmount = 1;
	private $leafDistanceLimit = 5;
	private $widthScale = 1;
	private $branchSlope = 0.381;

	private $totalHeight = 6;
	private $leavesHeight = 3;
	protected $radiusIncrease = 0;
	private $addLeavesVines = false;
	private $addLogVines = false;
	private $addCocoaPlants = false;

	public function canPlaceObject(ChunkManager $level, $x, $y, $z){
		return false;
	}

	public function placeObject(ChunkManager $level, $x, $y, $z, $type){

		$this->trunkHeight = (int) ($this->totalHeight * $this->trunkHeightMultiplier);
		$leaves = $this->getLeafGroupPoints($level, $pos);
		foreach($leaves as $leafGroup){
			$groupX = $leafGroup->getBlockX();
			$groupY = $leafGroup->getBlockY();
			$groupZ = $leafGroup->getBlockZ();
			for($yy = $groupY; $yy < $groupY + $this->leafDistanceLimit; ++$yy){
				$this->generateGroupLayer($level, $groupX, $yy, $groupZ, $this->getLeafGroupLayerSize($yy - $groupY));
			}
		}
		/*final BlockIterator trunk = new BlockIterator(new Point(w, x, y - 1, z), new Point(w, x, y + trunkHeight, z));
		while (trunk.hasNext()){
			trunk.next().setMaterial(VanillaMaterials.LOG, logMetadata);
		}
		generateBranches(w, x, y, z, leaves);

		$level->setBlock($x, $pos->y - 1, $z, 3, 0);
		$this->totalHeight += $random->nextRange(0, 2);
		$this->leavesHeight += mt_rand(0, 1);
		for($yy = ($this->totalHeight - $this->leavesHeight); $yy < ($this->totalHeight + 1); ++$yy){
			$yRadius = ($yy - $this->totalHeight);
			$xzRadius = (int) (($this->radiusIncrease + 1) - $yRadius / 2);
			for($xx = -$xzRadius; $xx < ($xzRadius + 1); ++$xx){
				for($zz = -$xzRadius; $zz < ($xzRadius + 1); ++$zz){
					if((abs($xx) != $xzRadius or abs($zz) != $xzRadius) and $yRadius != 0){
						$level->setBlock($pos->x + $xx, $pos->y + $yy, $pos->z + $zz, 18, $type);
					}
				}
			}
		}
		for($yy = 0; $yy < ($this->totalHeight - 1); ++$yy){
			$level->setBlock($x, $pos->y + $yy, $z, 17, $type);
		}
		*/
	}


}