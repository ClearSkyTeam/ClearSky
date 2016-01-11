<?php
/**
 * Math related classes, like matrices, bounding boxes and vector
 */
namespace pocketmine\math;


abstract class Math{

	public static function floorFloat($n){
		$i = (int) $n;
		return $n >= $i ? $i : $i - 1;
	}

	public static function ceilFloat($n){
		$i = (int) ($n + 1);
		return $n >= $i ? $i : $i - 1;
	}
}