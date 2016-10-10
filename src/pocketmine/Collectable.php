<?php
namespace pocketmine;

abstract class Collectable extends \Threaded implements \Collectable{

    private $isGarbage = false;
    
    public function isGarbage(){
        return $this->isGarbage;
    }

    public function setGarbage(){
        $this->isGarbage = true;
    }
}
