<?php
namespace pocketmine\utils;


/**
 * Unsecure Random Number Noise, used for fast seeded values
 */
class Random{

	protected $seed;

	/**
	 * @param int $seed Integer to be used as seed.
	 */
	public function __construct($seed = -1){
		if($seed == -1){
			$seed = time();
		}

		$this->setSeed($seed);
	}

	/**
	 * @param int $seed Integer to be used as seed.
	 */
	public function setSeed($seed){
		$this->seed = crc32(pack("N", $seed));
	}

	/**
	 * Returns an 31-bit integer (not signed)
	 *
	 * @return int
	 */
	public function nextInt(){
		return $this->nextSignedInt() & 0x7fffffff;
	}

	/**
	 * Does the same shit like Forge does
	 * this is not equal to nextBoundedInt, because
	 * lets face it..
	 * thats just shit.
	 *
	 * @return int
	 */
	public function nextIntBound(int $bound){
		if($bound <= 0) throw new \InvalidKeyException("Bound $bound must be positive"); // may needs a change
		if(($bound & -$bound) == $bound) return (int) (($bound * $this->next(31)) >> 31); // i.e., bound is a power of 2
		else{
			do{
				$bits = $this->next(31);
				$val = $bits % $bound;
			}
			while($bits - $val + ($bound - 1) < 0);
			return $val;
		}
		return r;
	}

	/**
	 * Generates the next pseudorandom number.
	 * Vanilla, because nextSignedInt is not calculating in a valid way
	 *
	 * @param int $bits 
	 */
	public function next(int $bits){
		$seed = $this->seed;
		($seed * 0x5DEECE66D + 0xB) & ((1 << 48) - 1);
		return (int) ($seed >> (48 - $bits)); // >>> operator, adding 0 in front
	}

	/**
	 * Returns a 32-bit integer (signed)
	 *
	 * @return int
	 */
	public function nextSignedInt(){
		$t = ((($this->seed * 65535) + 31337) >> 8) + 1337;
		if(PHP_INT_SIZE === 8){
			$t = $t << 32 >> 32;
		}
		$this->seed ^= $t;

		return $t;
	}

	/**
	 * Returns a float between 0.0 and 1.0 (inclusive)
	 *
	 * @return float
	 */
	public function nextFloat(){
		return $this->nextInt() / 0x7fffffff;
	}

	/**
	 * Returns a float between -1.0 and 1.0 (inclusive)
	 *
	 * @return float
	 */
	public function nextSignedFloat(){
		return $this->nextSignedInt() / 0x7fffffff;
	}

	/**
	 * Returns a random boolean
	 *
	 * @return bool
	 */
	public function nextBoolean(){
		return ($this->nextSignedInt() & 0x01) === 0;
	}

	/**
	 * Returns a random integer between $start and $end
	 *
	 * @param int $start default 0
	 * @param int $end   default 0x7fffffff
	 *
	 * @return int
	 */
	public function nextRange($start = 0, $end = 0x7fffffff){
		return $start + ($this->nextInt() % ($end + 1 - $start));
	}

	public function nextBoundedInt($bound){
		return $this->nextInt() % $bound;
	}

}