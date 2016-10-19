<?php

namespace pocketmine\entity\ai;

use pocketmine\entity\Human;
use pocketmine\entity\Wolf;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class WolfAI extends BaseAI{
	public static $speed = 0.2;
	public static $jump = 4;
	public static $dist = 4;
	public $width = 0.625;
	public $length = 1.4375;
	public $height = 1.25;

	public function calculateMovement($entitytype, $json){
		#if($entitytype instanceof Wolf){
			$jsondecode = json_decode($json, true);
			#$entitytype->setNameTag("Tillow");
			#$entitytype->setNameTagVisible();
			$entitytype = new Vector3($jsondecode['x'], $jsondecode['y'], $jsondecode['z']);
			#$collide = new Vector3($jsondecode['x'] + 0.1, $jsondecode['y'] + 0.1, $jsondecode['z'] + 0.1);
			// if(count($collide = $entitytype->getLevel()->getCollidingEntities(new AxisAlignedBB($jsondecode['x'] - 3, $jsondecode['y']- 3, $jsondecode['z'] - 3, $jsondecode['x'] + 3, $jsondecode['y'] + 3, $jsondecode['z'] + 3), $entitytype)) == 1){
			// if($collide instanceof Human){
			
			/*$dist = $entitytype->distance($collide);
			$dir = $collide->getLevel()->getSafeSpawn($collide)->subtract($jsondecode['x'], $jsondecode['y'], $jsondecode['z']);
			$dir = $dir->divide($dist);
			$this->yaw = rad2deg(atan2(-$dir->getX(), $dir->getZ()));
			$this->pitch = rad2deg(atan(-$dir->getY()));
			if($dist > self::$dist){
				$x = $dir->getX() * self::$speed;
				$y = 0;
				$z = $dir->getZ() * self::$speed;
				// $isJump = count($this->level->getCollisionBlocks($bb->offset($x, 1.2, $z))) <= 0;
				
				// if(count($this->level->getCollisionBlocks($bb->offset(0, 0.1, $z))) > 0){
				// if ($isJump) {
				// $y = self::$jump;
				// $this->motionZ = $z;
				// }
				// $z = 0;
				// }
				
				// if(count($this->level->getCollisionBlocks($bb->offset($x, 0.1, 0))) > 0){
				// if ($isJump) {
				// $y = self::$jump;
				// $this->motionX = $x;
				// }
				// $x = 0;
				// }
				
				// if ($y) echo "Jumping\n";
				// $ev = new \pocketmine\event\entity\EntityMotionEvent($this,new \pocketmine\math\Vector3($x,$y,$z));
				// $this->server->getPluginManager()->callEvent($ev);
				// if ($ev->isCancelled()) return false;
				$jsondecode['x'] += $x;
				$jsondecode['y'] += $y;
				$jsondecode['z'] += $z;
				print_r($jsondecode);
			}*/
			$x = $y = $z = 0;
			switch (floor($jsondecode['exe']/10)%8){
				case 0:{
					$x = 0.1;
					break;
				}
				case 1:{
					$x = 0.1;
					$z = 0.1;
					break;
				}
				case 2:{
					$z = 0.1;
					break;
				}
				case 3:{
					$x = -0.1;
					$z = 0.1;
					break;
				}
				case 4:{
					$x = -0.1;
					break;
				}
				case 5:{
					$x = -0.1;
					$z = -0.1;
					break;
				}
				case 6:{
					$z = -0.1;
					break;
				}
				default:{
					$x = 0.1;
					$z = -0.1;
					break;
				}
			}
				$jsondecode['x'] += $x;
				$jsondecode['y'] += $y;
				$jsondecode['z'] += $z;
		#}else return $json;
		// }
		// }
		return json_encode($jsondecode);
	}
}