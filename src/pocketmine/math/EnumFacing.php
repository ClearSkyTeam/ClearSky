<?php
namespace pocketmine\math {

use pocketmine\utils\Random;
/*import com.google.common.base.Predicate;
import com.google.common.collect.Iterators;
import com.google.common.collect.Maps;
import java.util.Iterator;
import java.util.Map;
import java.util.Random;
import net.minecraft.util.math.MathHelper;
import net.minecraft.util.math.Vector3;*/

class EnumFacing implements \Serializable
{
	const DOWN = [0, 1, -1, "down", EnumFacing\AxisDirection::NEGATIVE, EnumFacing\Axis::Y, new Vector3(0, -1, 0)];
	const UP = [1, 0, -1, "up", EnumFacing\AxisDirection::POSITIVE, EnumFacing\Axis::Y, new Vector3(0, 1, 0)];
	const NORTH = [2, 3, 2, "north", EnumFacing\AxisDirection::NEGATIVE, EnumFacing\Axis::Z, new Vector3(0, 0, -1)];
	const SOUTH = [3, 2, 0, "south", EnumFacing\AxisDirection::POSITIVE, EnumFacing\Axis::Z, new Vector3(0, 0, 1)];
	const WEST = [4, 5, 1, "west", EnumFacing\AxisDirection::NEGATIVE, EnumFacing\Axis::X, new Vector3(-1, 0, 0)];
	const EAST = [5, 4, 3, "east", EnumFacing\AxisDirection::POSITIVE, EnumFacing\Axis::X, new Vector3(1, 0, 0)];

	/** Ordering index for D-U-N-S-W-E */
	private final $index;
	/** Index of the opposite Facing in the VALUES array */
	private final $opposite;
	/** Ordering index for the HORIZONTALS field (S-W-N-E) */
	private final $horizontalIndex;
	private final $name;
	private final $axis;
	private final $axisDirection;
	/** Normalized Vector that points in the direction of $this Facing */
	private final $directionVec;
	/** All facings in D-U-N-S-W-E order */
	public static final $VALUES = new EnumFacing([6]);
	/** All Facings with horizontal axis in order S-W-N-E */
	public static final $HORIZONTALS = new EnumFacing([4]);
	private static final $NAME_LOOKUP = [];

	public function __construct(int $indexIn, int $oppositeIn, int $horizontalIndexIn, $nameIn, EnumFacing\AxisDirection $axisDirectionIn, EnumFacing\Axis $axisIn, Vector3 $directionVecIn)
	{
		$this->index = $indexIn;
		$this->horizontalIndex = $horizontalIndexIn;
		$this->opposite = $oppositeIn;
		$this->name = $nameIn;
		$this->axis = $axisIn;
		$this->axisDirection = $axisDirectionIn;
		$this->directionVec = $directionVecIn;
	}

	/**
	 * Get the Index of $this Facing (0-5). The order is D-U-N-S-W-E
	 * @return int
	 */
	public function getIndex()
	{
		return $this->index;
	}

	/**
	 * Get the index of $this horizontal facing (0-3). The order is S-W-N-E
	 * @return int
	 */
	public function getHorizontalIndex()
	{
		return $this->horizontalIndex;
	}

	/**
	 * Get the AxisDirection of $this Facing.
	 * @return EnumFacing\AxisDirection
	 */
	public function getAxisDirection()
	{
		return $this->axisDirection;
	}

	/**
	 * Get the opposite Facing (e.g. DOWN => UP)
	 * @return EnumFacing
	 */
	public function getOpposite()
	{
		/**
		 * Get a Facing by it's index (0-5). The order is D-U-N-S-W-E. Named getFront for legacy reasons.
		 */
		return getFront($this->opposite);
	}

	/**
	 * Rotate $this Facing around the given axis clockwise. If $this facing cannot be rotated around the given axis,
	 * returns $this facing without rotating.
	 * @return EnumFacing
	 */
	public function rotateAround(EnumFacing\Axis $axis)
	{
		switch ($axis)
		{
			case "X":

				if ($this != self::WEST && $this != self::EAST)
				{
					return $this->rotateX();
				}

				return $this;
			case "Y":

				if ($this != self::UP && $this != self::DOWN)
				{
					return $this->rotateY();
				}

				return $this;
			case "Z":

				if ($this != self::NORTH && $this != self::SOUTH)
				{
					return $this->rotateZ();
				}

				return $this;
			default:
				throw new \InvalidStateException("Unable to get CW facing for axis " . $axis);
		}
	}

	/**
	 * Rotate $this Facing around the Y axis clockwise (NORTH => EAST => SOUTH => WEST => NORTH)
	 * @return EnumFacing
	 */
	public function rotateY()
	{
		switch ($this)
		{
			case self::NORTH:
				return self::EAST;
			case self::EAST:
				return self::SOUTH;
			case self::SOUTH:
				return self::WEST;
			case self::WEST:
				return self::NORTH;
			default:
				throw new \InvalidStateException("Unable to get Y-rotated facing of " . $this);
		}
	}

	/**
	 * Rotate $this Facing around the X axis (NORTH => DOWN => SOUTH => UP => NORTH)
	 * @return EnumFacing
	 */
	private function rotateX()
	{
		switch ($this)
		{
			case self::NORTH:
				return self::DOWN;
			case self::EAST:
			case self::WEST:
			default:
				throw new \InvalidStateException("Unable to get X-rotated facing of " . $this);
			case self::SOUTH:
				return self::UP;
			case self::UP:
				return self::NORTH;
			case self::DOWN:
				return self::SOUTH;
		}
	}

	/**
	 * Rotate $this Facing around the Z axis (EAST => DOWN => WEST => UP => EAST)
	 * @return EnumFacing
	 */
	private function rotateZ()
	{
		switch ($this)
		{
			case self::EAST:
				return self::DOWN;
			case self::SOUTH:
			default:
				throw new \InvalidStateException("Unable to get Z-rotated facing of " . $this);
			case self::WEST:
				return self::UP;
			case self::UP:
				return self::EAST;
			case self::DOWN:
				return self::WEST;
		}
	}

	/**
	 * Rotate $this Facing around the Y axis counter-clockwise (NORTH => WEST => SOUTH => EAST => NORTH)
	 * @return EnumFacing
	 */
	public function rotateYCCW()
	{
		switch ($this)
		{
			case self::NORTH:
				return self::WEST;
			case self::EAST:
				return self::NORTH;
			case self::SOUTH:
				return self::EAST;
			case self::WEST:
				return self::SOUTH;
			default:
				throw new \InvalidStateException("Unable to get CCW facing of " . $this);
		}
	}

	/**
	 * Returns a offset that addresses the block in front of $this facing.
	 * @return int
	 */
	public function getFrontOffsetX()
	{
		return $this->axis == EnumFacing\Axis::X ? $this->axisDirection->getOffset() : 0;
	}

	/**
	 * Returns a offset that addresses the block in front of $this facing.
	 * @return int
	 */
	public function getFrontOffsetY()
	{
		return $this->axis == EnumFacing\Axis::Y ? $this->axisDirection->getOffset() : 0;
	}

	/**
	 * Returns a offset that addresses the block in front of $this facing.
	 * @return int
	 */
	public function getFrontOffsetZ()
	{
		return $this->axis == EnumFacing\Axis::Z ? $this->axisDirection.getOffset() : 0;
	}

	/**
	 * Same as getName, but does not override the method from Enum.
	 * @return string
	 */
	public function getName2()
	{
		return $this->name;
	}

	/**
	 * @return EnumFacing\Axis
	 */
	public function getAxis()
	{
		return $this->axis;
	}

	/**
	 * Get the facing specified by the given name
	 * @return EnumFacing
	 */
	public static function byName($name)
	{
		return $name == null ? null : self::$NAME_LOOKUP->get(strtolower($name));//?
	}

	/**
	 * Get a Facing by it's index (0-5). The order is D-U-N-S-W-E. Named getFront for legacy reasons.
	 * @return EnumFacing
	 */
	public static function getFront(int $index)
	{
		return self::$VALUES[abs($index % count(self::$VALUES))];
	}

	/**
	 * Get a Facing by it's horizontal index (0-3). The order is S-W-N-E.
	 * @return EnumFacing
	 */
	public static function getHorizontal(int $p_176731_0_)
	{
		return self::$HORIZONTALS[abs($p_176731_0_ % count(self::$HORIZONTALS))];
	}

	/**
	 * Get the Facing corresponding to the given angle (0-360). An angle of 0 is SOUTH, an angle of 90 would be WEST.
	 * @return EnumFacing
	 */
	public static function fromAngle(double $angle)
	{
		/**
		 * Get a Facing by it's horizontal index (0-3). The order is S-W-N-E.
		 */
		return $this->getHorizontal(floor($angle / 90.0 + 0.5) & 3);
	}

	/**
	 * @return float
	 */
	public function getHorizontalAngle()
	{
		return (float)(($this->horizontalIndex & 3) * 90);
	}

	/**
	 * Choose a random Facing using the given Random
	 * @return EnumFacing
	 */
	public static function random(Random $rand)
	{
		return values()[$rand->nextInt(values().length)];//?
	}

	/**
	 * @return EnumFacing
	 */
	public static function getFacingFromVector(float $p_176737_0_, float $p_176737_1_, float $p_176737_2_)
	{
		$enumfacing = self::NORTH;
		(float) $f = 0.0;//?

		foreach ($enumfacing as $enumfacing1)//values of what //?
		{
			(float) $f1 = $p_176737_0_ * (float) $enumfacing1->directionVec->getX() + $p_176737_1_ * (float) $enumfacing1->directionVec->getY() + $p_176737_2_ * (float) $numfacing1->directionVec->getZ();//? directionVec

			if ($f1 > $f)
			{
				$f = $f1;
				$enumfacing = $enumfacing1;
			}
		}

		return $enumfacing;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return EnumFacing
	 */
	public static function getFacingFromAxis(EnumFacing\AxisDirection $p_181076_0_, EnumFacing\Axis $p_181076_1_)
	{
		foreach ($this as $enumfacing)//? values
		{
			if ($enumfacing->getAxisDirection() == $p_181076_0_ && $enumfacing->getAxis() == $p_181076_1_)
			{
				return $enumfacing;
			}
		}

		throw new \InvalidArgumentException("No such direction: " . $p_181076_0_ . " " . $p_181076_1_);
	}

	/**
	 * Get a normalized Vector that points in the direction of $this Facing.
	 * @return Vector3
	 */
	public function getDirectionVec()
	{
		return $this->directionVec;
	}

/*	static //?
	{
		for (EnumFacing enumfacing : values())
		{
			VALUES[enumfacing.index] = enumfacing;

			if (enumfacing.getAxis().isHorizontal())
			{
				HORIZONTALS[enumfacing.horizontalIndex] = enumfacing;
			}

			NAME_LOOKUP.put(enumfacing.getName2().toLowerCase(), enumfacing);
		}
	}*/
}
}
namespace pocketmine\math\EnumFacing{
	use pocketmine\math\EnumFacing;
	/**
	 * @return enum
	 */
	class Axis implements \Serializable{//something missing here
		const X = ["x", EnumFacing\Plane::HORIZONTAL];
		const Y = ["y", EnumFacing\Plane::VERTICAL];
		const Z = ["z", EnumFacing\Plane::HORIZONTAL];

		private static final $NAME_LOOKUP = [];//? hashmap?
		private final $name;
		private final $plane;

		public function __construct($name, EnumFacing\Plane $plane)
		{
			$this->name = $name;
			$this->plane = $plane;
		}

		/**
		 * Get the axis specified by the given name
		 * @return EnumFacing\Axis
		 */
		public static function byName($name)
		{
			return $name == null ? null : self::$NAME_LOOKUP->get($name->__toLowerCase());//?
		}

		/**
		 * Like getName but doesn't override the method from Enum.
		 * @return string
		 */
		public function getName2()
		{
			return $this->name;
		}

		/**
		 * If $this Axis is on the vertical plane (Only true for Y)
		 * @return boolean
		 */
		public function isVertical()
		{
			return $this->plane == EnumFacing\Plane::VERTICAL;
		}

		/**
		 * If $this Axis is on the horizontal plane (true for X and Z)
		 * @return boolean
		 */
		public function isHorizontal()
		{
			return $this->plane == EnumFacing\Plane::HORIZONTAL;
		}

		/**
		 * @return string
		 */
		public function __toString()
		{
			return $this->name;
		}

		/**
		 * @return boolean
		 */
		public function apply(EnumFacing $p_apply_1_)
		{
			return $p_apply_1_ != null && $p_apply_1_->getAxis() == $this;
		}

		/**
		 * Get $this Axis' Plane (VERTICAL for Y, HORIZONTAL for X and Z)
		 * @return EnumFacing\Plane
		 */
		public function getPlane()
		{
			return $this->plane;
		}

		/**
		 * @return string
		 */
		public function getName()
		{
			return $this->name;
		}

/*		static//?
		{
			for (EnumFacing.Axis enumfacing$axis : values())
			{
				NAME_LOOKUP.put(enumfacing$axis.getName2().toLowerCase(), enumfacing$axis);
			}
		}*/
	}
}
namespace pocketmine\math\EnumFacing{

	class AxisDirection {
		const POSITIVE = [1, "Towards positive"];
		const NEGATIVE = [-1, "Towards negative"];

		private final $offset;
		private final $description;

		public function __construct(int $offset, $description)
		{
			$this->offset = offset;
			$this->description = description;
		}

		/**
		 * Get the offset for this AxisDirection. 1 for POSITIVE, -1 for NEGATIVE
		 * @return int
		 */
		public function getOffset()
		{
			return $this->offset;
		}

		/**
		 * @return string
		 */
		public function __toString()
		{
			return $this->description;
		}
	}
}
namespace pocketmine\math\EnumFacing{
	use pocketmine\math\EnumFacing;
	use pocketmine\utils\Random;

	class Plane implements \Iterator{//? missing Predicate<EnumFacing>, 
		const HORIZONTAL = 0;
		const VERTICAL = 1;

		/**
		 * All EnumFacing values for $this Plane
		 * @return EnumFacing[]
		 */
		public function facings()
		{
			switch ($this)
			{
				case self::HORIZONTAL:
					return [EnumFacing::NORTH, EnumFacing::EAST, EnumFacing::SOUTH, EnumFacing::WEST];//new EnumFacing[]{EnumFacing.NORTH, EnumFacing.EAST, EnumFacing.SOUTH, EnumFacing.WEST};
				case VERTICAL:
					return [EnumFacing::UP, EnumFacing::DOWN];//new EnumFacing[] {EnumFacing.UP, EnumFacing.DOWN};
				default:
					throw new \InvalidArgumentException("Someone\'s been tampering with the universe!");
			}
		}

		/**
		 * Choose a random Facing from $this Plane using the given Random
		 * @return EnumFacing
		 */
		public function random(Random $rand)
		{
			$aenumfacing = $this->facings();
			return $aenumfacing[$rand->nextInt()];//? $aenumfacing.length
		}

		/**
		 * @return boolean
		 */
		public function apply(EnumFacing $p_apply_1_)
		{
			return $p_apply_1_ != null && $p_apply_1_->getAxis()->getPlane() == $this;
		}

		/**
		 * @return \Iterator
		 */
		public function iterator()
		{
			return $this->facings();//? Iterators.<EnumFacing>forArray($this->facings())
		}
	}
}