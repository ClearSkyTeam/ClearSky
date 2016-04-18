<?php
namespace pocketmine\level;

use pocketmine\block\Block;
use pocketmine\block\Redstone;
use pocketmine\block\RedstoneWire;

class Circut{
	private $level = null;
	private $source = null;
	private $power = 0;
	private $range = 0;
	private $map = [];
	
	public function __construct(Redstone $source){
		$this->source = $source;
		$this->level = $source->getLevel();
		$this->power = $source->getPower();
		$this->range = $source->getPower();
		$this->map = [$source => 0];
		$this->map = $this->map($this->build($source));
		$this->update();
	}
	
	private function map($layers){
		for($i = $this->power - 1; $i = 0; $i--){
			foreach($layers[$i] as $block){
				$map[$block] = $i;
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
	
	private function build(Block $block, $startlayer = 0){
		//Intl
		$syslayers = $this->layer($this->map);
		for($i = 0; $i <= $startlayer; $i++){
			$layers[$i] = $syslayers[$i];
		}
		//Start circut build process
		for($a = $startlayer; $a <= $block->getPower() - 1; $a++){
			foreach($layers[$a] as $block){
				for($b = 0; $b <= 5; $b++){
					$next = $block->getSide($b);
					if($a == 0 or in_array($next, $layers[$a - 1])){
						continue;
					}
					
					if($next instanceof RedstoneWire){
						$layers[$a + 1][] = $next;
					}
					
					
				}
			}
			if(!isset($layers[$a + 1])){
				break;
			}
		}
		//print_r($layers);
		return $layers;
	}
	
	public function tick(){
		
	}
	
	public function add(Block $block){
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
		$block->setPower($layer);
	}
	
	public function del(Block $block){
		$blocklayer = $block->getLayer();
		$oldlayers = $this->map;
		$updatelayers = $this->build($block, $blocklayer);
		
		for($i = 0; $i <= $blocklayer; $i++){
			unset($updatelayers[$i])
		}
		$difflayers = array_diff($oldlayer, $updatelayer);
		
		foreach($difflayers[$block->getLayer()] as $lblock){
			if($lblock !=== $block){
				$newlayers = array_merge($newlayers, $this->build($lblock, $blocklayer));
 			}
		}
		
		$layers = $this->build()
	}
	
	public function update(){
		foreach ($this->map as $block=>$powerlayer){
			if($this->source == null){
				$block->lostPower($this);
			}else{
				$block->setPower($this, $this->power - $powerlayer);
			}
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
		return $this->map[$block];
	}
	
	public function getPower(Redstone $block){
		return $this->power - $this->map[$block];
	}
	
}