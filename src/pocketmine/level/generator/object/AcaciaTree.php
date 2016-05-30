<?php

namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\block\Wood2;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\block\Air;
use pocketmine\block\Leaves;
use pocketmine\block\Leaves2;
use pocketmine\level\Level;

class AcaciaTree extends Tree{

	public function __construct(){
		$this->trunkBlock = Block::LOG;
		$this->leafBlock = Block::LEAVES;
		$this->type = Wood2::ACACIA;
		$this->treeHeight = 8;
	}

	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random){// ChunkManager -> Level
		$this->treeHeight = $random->nextBoundedInt(3) + $random->nextBoundedInt(3) + 5;
		$position = new Vector3($x, $y, $z);
		
		(int) $i = $this->treeHeight;
		(boolean) $flag = true;
		
		if($y >= 1 && $y + $i + 1 <= 128){
			for((int) $j = $y; $j <= $y + 1 + $i; ++$j){
				(int) $k = 1;
				
				if($j == $y){
					$k = 0;
				}
				
				if($j >= $y + 1 + $i - 2){
					$k = 2;
				}
				
				$mutableblockpos = clone $position;
				
				for((int) $l = $x - $k; $l <= $x + $k && $flag; ++$l){
					for((int) $i1 = $z - $k; $i1 <= $z + $k && $flag; ++$i1){
						if($j >= 0 && $j < 128){
							if(!Block::get($level->getBlockIdAt($l, $j, $i1), $level->getBlockDataAt($l, $j, $i1))->canBeReplaced()){
								$flag = false;
							}
						}
						else{
							$flag = false;
						}
					}
				}
			}
			
			if(!$flag){
				return false;
			}
			else{
				$down = $position->getSide(Vector3::SIDE_DOWN);
				$state = Block::get($level->getBlockIdAt($down->x, $down->y, $down->z), $level->getBlockDataAt($down->x, $down->y, $down->z));
				$isSoil = in_array($state->getId(), [Block::DIRT, Block::GRASS, Block::FARMLAND, Block::GRASS_PATH, Block::MYCELIUM, Block::PODZOL]);
				
				if($isSoil && $y < 128 - $i - 1){
					// state.getBlock().onPlantGrow(state, worldIn, down, position);
					// $enumfacing = EnumFacing.Plane.HORIZONTAL.random(mt_rand()); //???
					$enumfacing = $state;
					(int) $k2 = $i - mt_rand(4) - 1;
					(int) $l2 = 3 - mt_rand(3);
					(int) $i3 = $x;
					(int) $j1 = $z;
					(int) $k1 = 0;
					
					for((int) $l1 = 0; $l1 < $i; ++$l1){
						(int) $i2 = $y + $l1;
						
						if($l1 >= $k2 && $l2 > 0){
							// $i3 += $enumfacing.getFrontOffsetX();//???
							// $j1 += $enumfacing.getFrontOffsetZ();//???
							--$l2;
						}
						
						$blockpos = new Vector3($i3, $i2, $j1);
						$state = Block::get($level->getBlockIdAt($blockpos->x, $blockpos->y, $blockpos->z), $level->getBlockDataAt($blockpos->x, $blockpos->y, $blockpos->z));
						
						if($state instanceof Air || $state instanceof Leaves || $state instanceof Leaves2){
							$this->func_181642_b($level, $blockpos);
							$k1 = $i2;
						}
					}
					
					$blockpos2 = new Vector3($i3, $k1, $j1);
					
					for((int) $j3 = -3; $j3 <= 3; ++$j3){
						for((int) $i4 = -3; $i4 <= 3; ++$i4){
							if(abs($j3) != 3 || abs($i4) != 3){
								$this->func_175924_b($level, $blockpos2->add($j3, 0, $i4));
							}
						}
					}
					
					$blockpos2 = $blockpos2->getSide(Vector3::SIDE_UP);
					
					for((int) $k3 = -1; $k3 <= 1; ++$k3){
						for((int) $j4 = -1; $j4 <= 1; ++$j4){
							$this->func_175924_b($level, $blockpos2->add($k3, 0, $j4));
						}
					}
					
					$this->func_175924_b($level, $blockpos2->getSide(Vector3::SIDE_EAST, 2));
					$this->func_175924_b($level, $blockpos2->getSide(Vector3::SIDE_WEST, 2));
					$this->func_175924_b($level, $blockpos2->getSide(Vector3::SIDE_SOUTH, 2));
					$this->func_175924_b($level, $blockpos2->getSide(Vector3::SIDE_NORTH, 2));
					$i3 = $x;
					$j1 = $z;
					// $enumfacing1 = EnumFacing.Plane.HORIZONTAL.random(mt_rand());//?
					$enumfacing = $blockpos2;
					
					if($enumfacing1 != $enumfacing){
						(int) $l3 = $k2 - mt_rand(2) - 1;
						(int) $k4 = 1 + mt_rand(3);
						$k1 = 0;
						
						for((int) $l4 = $l3; $l4 < $i && $k4 > 0; --$k4){
							if($l4 >= 1){
								(int) $j2 = $y + $l4;
								//$i3 += $enumfacing1->getFrontOffsetX(); // ?
								//$j1 += $enumfacing1->getFrontOffsetZ(); // ?
								$blockpos1 = new Vector3($i3, $j2, $j1);
								$state = Block::get($level->getBlockIdAt($blockpos1->x, $blockpos1->y, $blockpos1->z), $level->getBlockDataAt($blockpos1->x, $blockpos1->y, $blockpos1->z));
								
								if($state instanceof Air || $state instanceof Leaves || $state instanceof Leaves2){
									$this->func_181642_b($level, $blockpos1);
									$k1 = $j2;
								}
							}
							
							++$l4;
						}
						
						if($k1 > 0){
							$blockpos3 = new Vector3($i3, $k1, $j1);
							
							for((int) $i5 = -2; $i5 <= 2; ++$i5){
								for((int) $k5 = -2; $k5 <= 2; ++$k5){
									if(abs($i5) != 2 || abs($k5) != 2){
										$this->func_175924_b($level, $blockpos3->add($i5, 0, $k5));
									}
								}
							}
							
							$blockpos3 = $blockpos3->getSide(Vector3::SIDE_UP);
							
							for((int) $j5 = -1; $j5 <= 1; ++$j5){
								for((int) $l5 = -1; $l5 <= 1; ++$l5){
									$this->func_175924_b($level, $blockpos3->add($j5, 0, $l5));
								}
							}
						}
					}
					
					return true;
				}
				else{
					return false;
				}
			}
		}
		else{
			return false;
		}
	}

	private function func_181642_b(Level $p_181642_1_, Vector3 $p_181642_2_){
		$p_181642_1_->setBlock($p_181642_2_, Block::get($this->trunkBlock, $this->type));
	}

	private function func_175924_b(Level $worldIn, Vector3 $p_175924_2_){
		$state = $worldIn->getBlock($p_175924_2_);
		
		if($state instanceof Air || $state instanceof Leaves || $state instanceof Leaves2){
			$worldIn->setBlock($p_175924_2_, Block::get($this->leafBlock, $this->type));
		}
	}
}