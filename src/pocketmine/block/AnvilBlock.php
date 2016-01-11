<?php
namespace pocketmine\block;

use pocketmine\inventory\AnvilInventory;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;

class AnvilBlock extends Fallable{
    const TYPE_ANVIL = 0;
    const TYPE_SLIGHTLY_DAMAGED_ANVIL = 4;
    const TYPE_VERY_DAMAGED_ANVIL = 8;

    protected $id = self::ANVIL_BLOCK;

    public function isSolid(){
        return false;
    }

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function canBeActivated(){
        return true;
    }

    public function getHardness(){
        return 5;
    }

    public function getResistance(){
        return 6000;
    }

    public function getName(){
        static $names = [
            self::TYPE_ANVIL => "Anvil",
            1 => "Anvil",
            2 => "Anvil",
            3 => "Anvil",
            self::TYPE_SLIGHTLY_DAMAGED_ANVIL => "Slighty Damaged Anvil",
            5 => "Slighty Damaged Anvil",
            6 => "Slighty Damaged Anvil",
            7 => "Slighty Damaged Anvil",
            self::TYPE_VERY_DAMAGED_ANVIL => "Very Damaged Anvil",
            9 => "Very Damaged Anvil",
            10 => "Very Damaged Anvil",
            11 => "Very Damaged Anvil"
        ];
        return $names[$this->meta];
    }

    public function getToolType(){
        return Tool::TYPE_PICKAXE;
    }

    public function onActivate(Item $item, Player $player = null){
        if($player instanceof Player){
            if($player->isCreative()){
                return true;
            }

            $player->addWindow(new AnvilInventory($this));
        }

        return true;
    }

    public function getDrops(Item $item){
        $damage = $this->getDamage();
        if($item->isPickaxe() >= Tool::TIER_WOODEN){
            if($damage >= 0 && $damage <= 3){ //Anvil
                return [[$this->id, 0, 1]];

            }elseif($damage >= 4 && $damage <= 7){//Slightly Anvil
                return [[$this->id, $this->meta & 0x04, 1]];

            }elseif($damage >= 8 && $damage <= 11){ //Very Damaged Anvil
                return [[$this->id, $this->meta & 0x08, 1]];
            }
        }else{
            return [];
        }
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if ($target->isTransparent() === false) {
            $faces = [
                0 => 0,
                1 => 1,
                2 => 2,
                3 => 3,
            ];

            $damage = $this->getDamage();
            $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0] & 0x04;

            if($damage >= 0 && $damage <= 3){
                $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0];
                
            }elseif($damage >= 4 && $damage <= 7){
                $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0] | 0x04;

            }elseif($damage >= 8 && $damage <= 11){
                $this->meta = $faces[$player instanceof Player ? $player->getDirection() : 0] | 0x08;

            }
            $this->getLevel()->setBlock($block, $this, true);
            return true;
        }
        return false;
    }
}