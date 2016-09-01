<?php

namespace pocketmine\level\generator\normal\biome;

/*
 * import java.util.Arrays;
 * import java.util.Random;
 * import net.minecraft.block.BlockColored;
 * import net.minecraft.block.BlockDirt;
 * import net.minecraft.block.BlockSand;
 * import net.minecraft.block.material.Material;
 * import net.minecraft.block.state.IBlockState;
 * import net.minecraft.init.Blocks;
 * import net.minecraft.item.EnumDyeColor;
 * import net.minecraft.util.math.BlockPos;
 * import net.minecraft.world.World;
 * import net.minecraft.world.chunk.ChunkPrimer;
 * import net.minecraft.world.gen.NoiseGeneratorPerlin;
 * import net.minecraft.world.gen.feature.WorldGenAbstractTree;
 * import net.minecraftforge.fml.relauncher.Side;
 * import net.minecraftforge.fml.relauncher.SideOnly;
 */
use pocketmine\block\Block;
use pocketmine\utils\Random;
use pocketmine\level\Level;
use pocketmine\level\generator\noise\Perlin;
use pocketmine\level\SimpleChunkManager;
use pocketmine\block\Sapling;
use pocketmine\level\generator\populator\Tree;
use pocketmine\level\generator\populator\DeadBush;
use pocketmine\level\generator\populator\Sugarcane;
use pocketmine\level\generator\populator\Cactus;
use pocketmine\level\generator\biome\Biome;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\noise\Simplex;
use pocketmine\level\generator\Generator;

class MesaBiome extends GrassyBiome{ // BiomeGenBase
	private $field_185385_y;
	private $field_185386_z;
	private $field_185381_A;
	private $field_185382_B;
	private $field_185383_C;
	private $field_185384_D;
	private $field_150621_aC = []; // IBlockState[]
	private $field_150622_aD; // long
	private $field_150623_aE; // NoiseGeneratorPerlin
	private $field_150624_aF; // NoiseGeneratorPerlin
	private $field_150625_aG; // NoiseGeneratorPerlin
	private $field_150626_aH = false; // boolean
	private $field_150620_aI = false;
	// boolean
	public function __construct(){
		parent::__construct();
		$this->clearPopulators();
		$this->field_185385_y = Block::get(Block::DIRT, 1);
		$this->field_185386_z = Block::get(Block::GRASS);
		$this->field_185381_A = Block::get(Block::HARDENED_CLAY);
		$this->field_185382_B = Block::get(Block::STAINED_HARDENED_CLAY);
		$this->field_185383_C = Block::get(Block::STAINED_HARDENED_CLAY, 4);
		$this->field_185384_D = Block::get(Block::SAND, 1);
		$generatetrees = $p_i46704_1_ = mt_rand(0, 1) == 1;
		$this->setElevation(0, 0); // ?
		$this->setGroundCover([]);
		// $this->field_150626_aH = $p_i46704_1_;//was from construct: (boolean p_i46704_1_, boolean p_i46704_2_, BiomeGenBase.BiomeProperties properties)
		// $this->field_150620_aI = $p_i46704_2_;
		$this->topBlock = $this->field_185384_D;
		$this->fillerBlock = $this->field_185382_B;
		
		// $this->theBiomeDecorator.treesPerChunk = -999;
		$trees = new Tree(Sapling::OAK);
		$trees->setBaseAmount(0);
		// $this->theBiomeDecorator.deadBushPerChunk = 20;
		$tallGrass = new DeadBush();
		$tallGrass->setBaseAmount(20);
		// $this->theBiomeDecorator.reedsPerChunk = 3;
		$reeds = new Sugarcane();
		$reeds->setBaseAmount(3);
		// $this->theBiomeDecorator.cactiPerChunk = 5;
		$cacti = new Cactus();
		$cacti->setBaseAmount(5);
		// $this->theBiomeDecorator.flowersPerChunk = 0; //simply don't add i guess
		
		if($generatetrees){ // aah i see. may be the mesa forest isForest
			$trees->setBaseAmount(2); // 5
		}
		$this->addPopulator($trees);
		$this->addPopulator($tallGrass);
		$this->addPopulator($reeds);
		$this->addPopulator($cacti);
		
		$this->temperature = 0.8;
		$this->rainfall = 0.4;
	}

	public function getName(){
		return "Mesa";
	}

	/**
	 * The tree generator.
	 */
	public function genBigTreeChance(Random $rand){
		return $this->worldGeneratorTrees;
	}

	public function populateChunk(ChunkManager $level, $chunkX, $chunkZ, Random $random){
		print("Populating");
		/*$this->genTerrainBlocks($level, $random, $level, $chunkX, $chunkZ, new Simplex($random, 4, 1 / 4, 1 / 64));
	}

	public function genTerrainBlocks(/*Level * /ChunkManager $worldIn, Random $rand, SimpleChunkManager $chunkPrimerIn, $x, $z, $noiseVal){*/
		$noiseBase = new Simplex($random, 4, 1 / 4, 1 / 64);
		$noise = Generator::getFastNoise3D($noiseBase, 16, 128, 16, 4, 8, 4, $chunkX * 16, 0, $chunkZ * 16);
		$this->emptyHeight = 64; $this->emptyAmplitude = 5;
		$noiseValue = (abs($this->emptyHeight - 32) / $this->emptyHeight) * $this->emptyAmplitude - $noise[$chunkX][$chunkZ][32];
		$noiseValue -= 1 - 0.5;
		$worldIn = $level; $rand = $random;$x = $chunkX; $z = $chunkZ; $chunkPrimerIn = $level; $noiseVal = $noiseValue;
		if($this->field_150621_aC == null || $this->field_150622_aD != $worldIn->getSeed()){
			$this->func_150619_a($worldIn->getSeed());
		}
		
		if($this->field_150623_aE == null || $this->field_150624_aF == null || $this->field_150622_aD != $worldIn->getSeed()){
			$random = new Random($this->field_150622_aD);
			$this->field_150623_aE = new Perlin($random, 4, 1);
			$this->field_150624_aF = new Perlin($random, 1, 1);
		}
		
		$this->field_150622_aD = $worldIn->getSeed();
		$d4 = 0;
		
		if($this->field_150626_aH){ // false anyways
			$i = ($x & -16) + ($z & 15);
			$j = ($z & -16) + ($x & 15);
			$d0 = min(abs($noiseVal), $this->field_150623_aE->func_151601_a((double) $i * 0.25, (double) $j * 0.25)); // get function
			
			if($d0 > 0.0){
				$d1 = 0.001953125;
				$d2 = abs($this->field_150624_aF->func_151601_a((double) $i * $d1, (double) $j * $d1)); // get function
				$d4 = $d0 * $d0 * 2.5;
				$d3 = ceil($d2 * 50) + 14;
				
				if($d4 > $d3){
					$d4 = $d3;
				}
				
				$d4 = $d4 + 64;
			}
		}
		
		$j1 = 

		$x & 15;
		$k1 = $z & 15;
		$l1 = $chunkPrimerIn->getWaterHeight();
		$iblockstate = $this->field_185382_B;
		$iblockstate3 = $this->fillerBlock;
		$k = (int) ($noiseVal / 3 + 3 + $rand->nextInt() * 0.25); // nextDouble
		$flag = cos($noiseVal / 3 * pi()) > 0;
		$l = -1;
		$flag1 = false;
		
		for($i1 = 255; $i1 >= 0; --$i1){
			if($chunkPrimerIn->getBlockIdAt($k1, $i1, $j1) == Block::AIR && $i1 < $d4){
				$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, Block::STONE);
				$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, 0);
			}
			
			if($i1 <= $rand->nextIntBound(5)){
				$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, Block::BEDROCK);
				$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, 0);
			}
			else{
				$iblockstate1 = Block::get($chunkPrimerIn->getBlockIdAt($k1, $i1, $j1), $chunkPrimerIn->getBlockDataAt($k1, $i1, $j1));
				
				if($iblockstate1->getId() == Block::AIR){
					$l = -1;
				}
				elseif($iblockstate1->getId() == Block::STONE){
					if($l == -1){
						$flag1 = false;
						
						if($k <= 0){
							$iblockstate = Block::get(Block::AIR);
							$iblockstate3 = Block::get(Block::STONE);
						}
						elseif($i1 >= $l1 - 4 && $i1 <= $l1 + 1){
							$iblockstate = $this->field_185382_B;
							$iblockstate3 = $this->fillerBlock;
						}
						
						if($i1 < $l1 && ($iblockstate == null || $iblockstate->getId() == Block::AIR)){
							$iblockstate = block::get(Block::WATER); // maybe change to still water from water
						}
						
						$l = $k + max(0, $i1 - $l1);
						
						if($i1 < $l1 - 1){
							$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $iblockstate3);
							
							if($iblockstate3 == Block::get(Block::STAINED_HARDENED_CLAY)){
								$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $this->field_185383_C->getId());
								$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, $this->field_185383_C->getDamage());
							}
						}
						else if($this->field_150620_aI && $i1 > 86 + $k * 2){
							if($flag){
								$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $this->field_185385_y->getId());
								$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, $this->field_185385_y->getDamage());
							}
							else{
								$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $this->field_185386_z->getId());
								$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, $this->field_185386_z->getDamage());
							}
						}
						else if($i1 <= $l1 + 3 + $k){
							$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $this->topBlock->getId());
							$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, $this->topBlock->getDamage());
							$flag1 = true;
						}
						else{
							$iblockstate2 = null;
							
							if($i1 >= 64 && $i1 <= 127){
								if($flag){
									$iblockstate2 = $this->field_185381_A;
								}
								else{
									$iblockstate2 = $this->func_180629_a($x, $i1, $z);
								}
							}
							else{
								$iblockstate2 = $this->field_185383_C;
							}
							
							$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $iblockstate2->getId());
							$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, $iblockstate2->getDamage());
						}
					}
					else if($l > 0){
						--$l;
						
						if($flag1){
							$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $this->field_185383_C->getId());
							$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, $this->field_185383_C->getDamage());
						}
						else{
							$chunkPrimerIn->setBlockIdAt($k1, $i1, $j1, $this->func_180629_a($x, $i1, $z)->getId());
							$chunkPrimerIn->setBlockDataAt($k1, $i1, $j1, $this->func_180629_a($x, $i1, $z)->getDamage());
						}
					}
				}
			}
		}
	}

	public function func_150619_a($p_150619_1_){
		$this->field_150621_aC = array_fill(0, 64, clone $this->field_185381_A); // need clone, if not used setting one key will also set all other keys
		$random = new Random($p_150619_1_);
		$this->field_150625_aG = new Perlin($random, 1, 1);
		
		for($l1 = 0; $l1 < 64; ++$l1){
			$l1 += $random->nextIntBound(5) + 1;
			
			if($l1 < 64){
				$this->field_150621_aC[$l1] = $this->field_185383_C;
			}
		}
		
		$i2 = $random->nextIntBound(4) + 2;
		
		for($i = 0; $i < $i2; ++$i){
			$j = $random->nextIntBound(3) + 1;
			$k = $random->nextIntBound(64);
			
			for($l = 0; $k + $l < 64 && $l < $j; ++$l){
				$this->field_150621_aC[$k + $l] = (clone $this->field_185382_B)->setDamage(4); // cloning the block or can it be overidden?
			}
		}
		
		$j2 = $random->nextIntBound(4) + 2;
		
		for($k2 = 0; $k2 < $j2; ++$k2){
			$i3 = $random->nextIntBound(3) + 2;
			$l3 = $random->nextIntBound(64);
			
			for($i1 = 0; $l3 + $i1 < 64 && $i1 < $i3; ++$i1){
				$this->field_150621_aC[$l3 + $i1] = (clone $this->field_185382_B)->setDamage(12);
			}
		}
		
		$l2 = $random->nextIntBound(4) + 2;
		
		for($j3 = 0; $j3 < $l2; ++$j3){
			$i4 = $random->nextIntBound(3) + 1;
			$k4 = $random->nextIntBound(64);
			
			for($j1 = 0; $k4 + $j1 < 64 && $j1 < $i4; ++$j1){
				$this->field_150621_aC[$k4 + $j1] = (clone $this->field_185382_B)->setDamage(14);
			}
		}
		
		$k3 = $random->nextIntBound(3) + 3;
		$j4 = 0;
		
		for($l4 = 0; $l4 < $k3; ++$l4){
			$i5 = 1;
			$j4 += $random->nextIntBound(16) + 4;
			
			for($k1 = 0; $j4 + $k1 < 64 && $k1 < $i5; ++$k1){
				$this->field_150621_aC[$j4 + $k1] = (clone $this->field_185382_B)->setDamage(0);
				
				if($j4 + $k1 > 1 && $random->nextBoolean()) // maybe rewrite nextboolean
{
					$this->field_150621_aC[$j4 + $k1 - 1] = (clone $this->field_185382_B)->setDamage(7);
				}
				
				if($j4 + $k1 < 63 && $random->nextBoolean()){
					$this->field_150621_aC[$j4 + $k1 + 1] = (clone $this->field_185382_B)->setDamage(7);
				}
			}
		}
	}

	public function func_180629_a(int $p_180629_1_, int $p_180629_2_, int $p_180629_3_){
		$i = round($this->field_150625_aG->func_151601_a($p_180629_1_ / 512, $p_180629_1_ / 512) * 2);
		return $this->field_150621_aC[($p_180629_2_ + $i + 64) % 64];
	}
	
	/*
	 * @SideOnly(Side.CLIENT)
	 * public int getFoliageColorAtPos(BlockPos pos)
	 * {
	 * return 10387789;
	 * }
	 *
	 * @SideOnly(Side.CLIENT)
	 * public int getGrassColorAtPos(BlockPos pos)
	 * {
	 * return 9470285;
	 * }
	 */
}