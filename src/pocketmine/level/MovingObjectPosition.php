<?php
namespace pocketmine\level;

use pocketmine\entity\Entity;
use pocketmine\math\Vector3;

class MovingObjectPosition{

	/** 0 = block, 1 = entity */
	public $typeOfHit;

	public $blockX;
	public $blockY;
	public $blockZ;

	/**
	 * Which side was hit. If its -1 then it went the full length of the ray trace.
	 * Bottom = 0, Top = 1, East = 2, West = 3, North = 4, South = 5.
	 */
	public $sideHit;

	/** @var Vector3 */
	public $hitVector;

	/** @var Entity */
	public $entityHit = null;

	protected function __construct(){

	}

	/**
	 * @param int     $x
	 * @param int     $y
	 * @param int     $z
	 * @param int     $side
	 * @param Vector3 $hitVector
	 *
	 * @return MovingObjectPosition
	 */
	public static function fromBlock($x, $y, $z, $side, Vector3 $hitVector){
		$ob = new MovingObjectPosition;
		$ob->typeOfHit = 0;
		$ob->blockX = $x;
		$ob->blockY = $y;
		$ob->blockZ = $z;
		$ob->hitVector = new Vector3($hitVector->x, $hitVector->y, $hitVector->z);
		return $ob;
	}

	/**
	 * @param Entity $entity
	 *
	 * @return MovingObjectPosition
	 */
	public static function fromEntity(Entity $entity){
		$ob = new MovingObjectPosition;
		$ob->typeOfHit = 1;
		$ob->entityHit = $entity;
		$ob->hitVector = new Vector3($entity->x, $entity->y, $entity->z);
		return $ob;
	}
}
