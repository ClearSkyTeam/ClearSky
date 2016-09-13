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

	public static function clamp($value, $low, $high){
		return min($high, max($low, $value));
	}

	public static function solveQuadratic($a, $b, $c){
		$x[0] = (-$b + sqrt($b ** 2 - 4 * $a * $c)) / (2 * $a);
		$x[1] = (-$b - sqrt($b ** 2 - 4 * $a * $c)) / (2 * $a);
		if($x[0] == $x[1]){
			return [$x[0]];
		}
		return $x;
	}
}