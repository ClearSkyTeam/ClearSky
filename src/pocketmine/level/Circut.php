<?php
namespace pocketmine\level;

use pocketmine\block\Block;
use pocketmine\block\Redstone;
use pocketmine\block\RedstoneWire;

class Circut{
	private $isdestroy = false;
	private $level = null;
	private $source = null;
	private $power = 0;
	private $range = 0;
	private $hashmap = [];
	private $map = [];
	private $laststatus= [];
	
	public function __construct(Redstone $source){
		$this->source = $source;
		$this->level = $source->getLevel();
		$this->power = $source->getPower();
		$this->level->addCircut($source, $this);
		$this->map = [$this->getHash($source) => 0];
		$this->map = $this->map($this->build($this->getHash($source)));
	}
	
	private function getHash($block){
		$hash = $block->x . $block->y . $block->z;
		$this->hashmap[$hash] = $block;
		return $hash;
	}
	
	private function getBlock($hash){
		return $this->hashmap[$hash];
	}
	
	private function map($layers){
		$map = [];
		for($i = $this->power; $i>=0;$i--){
			if(isset($layers[$i])){
				foreach($layers[$i] as $block){
					$map[$block] = $i;
				}
			}
		}
		return $map;
	}
	
	private function layer($map){
		foreach($map as $block => $powerlayer){
			$layers[$powerlayer][] = $block;
		}
		return $layers;
	}
	
	private function build($block, $startlayer = 0){
		$layers = [];
		$block = $this->getBlock($block);
		$blockpower = $block->getPower();
		$syslayers = $this->layer($this->map);
		for($i = 0; $i <= $startlayer; $i++){
			$layers[$i] = $syslayers[$i];
		}
		
		for($a = $startlayer;$a<=$blockpower-1; $a++){
			echo "Layer Calcation : $a \n";
			foreach($layers[$a] as $block){
				$block = $this->getBlock($block);
					for($b = 0; $b <= 5; $b++){
						echo "Side Calcation : $b \n";
						$next = $block->getSide($b);
						if($a !== 0){
							if(in_array($this->getHash($next), $layers[$a - 1])){
								continue;
							}
						}
						
						if($next instanceof RedstoneWire){
							echo "Side Calcation Added: " . $this->getHash($next) . " \n";
							$layers[$a + 1][] = $this->getHash($next);
						}
						
						
					}
			}
			
			if(!isset($layers[$a + 1])){
				echo "Layer Calcation Stop At: $a \n";
				break;
			}
			
		}
		echo "Layer: ";
		print_r($layers);
		return $layers;
	}
	
	public function tick(){
		$status = [$this->source, $this->power, $this->map];
		//echo "Circut Tick \n";
		if($this->laststatus !== $status){
			echo"Circut Update \n";
			$this->laststatus = $status;
			$this->update();
		}
	}
	
	public function add($block){
		$layer = $this->power - 1;
		for($a = 0; $a <= 5; $a++){
			$nears[] = $block->getSide($a);
		}
		
		foreach($nears as $near){
			if(isset($this->map[$near])){
				$layer = min($this->map[$near], $layer);
			}
		}
		
		$this->map[$block] = $layer;
	}
	
	public function del($block){
		$blocklayer = $this->getLayer($block);
		$block = $this->getHash($block);
		$map = $this->map;
		unset($map[$block]);
		$layers = $this->layer($map);
		$final = [];
		
		foreach($layers as $layer=>$blocks){
			if($layer<$blocklayer){
				foreach($blocks as $block){
					$final[$block] = $layer;
				}
			}else{
				foreach($blocks as $block){
					$final[$block] = 99;
				}
			}
		}
		
		$rs = [];
		print_r($layers);
		if(isset($layers[$blocklayer])){
			foreach($layers[$blocklayer] as $block){
				$rs[] = $this->map($this->build($this->getBlock($block), $blocklayer));
			}
		}
		
		foreach($rs as $map){
			foreach($map as $block=>$layer){
				if($layer < $final[$block]){
					$final[$block] = $layer;
				}
			}
		}
		echo "Del And Updated Map:";
		print_r($final);
		$this->map = $final;
	}
	
	public function update(){
		echo "Map: ";
		print_r($this->map);
		foreach ($this->map as $block=>$powerlayer){
			$block = $this->getBlock($block);
			if($powerlayer == 99){
				$block->onCircutRemove($this);
			}elseif($block instanceof RedstoneWire){
				$block->setPower(max($this->power - $powerlayer, 0));
			}/*elseif($block instanceof RedstoneCosumer){
				if($this->power - $powerlayer > 0){
					$block->onUpdate(Block::POWERON);
				}else{
					$block->onUpdate(Block::POWEROFF);
				}
			}*/
		}
	}
	
	public function getLevel(){
		return $this->level;
	}
	
	public function getSource(){
		return $this->source;
	}
	
	public function getlayers(){
		return $this->layers;
	}
	
	public function getLayer(Redstone $block){
		$block = $this->getHash($block);
		if(isset($this->map[$block])){
			return $this->map[$block];
		}else{
			return $this->power;
		}
	}
	
	public function getPower(Redstone $block){
		$block = $this->getHash($block);
		return max($this->power - $this->map[$block], 0);
	}
	
}