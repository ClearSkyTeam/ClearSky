<?php
namespace raklib\protocol;

use raklib\Binary;
#include <rules/RakLibPacket.h>


use raklib\RakLib;

class UNCONNECTED_PING extends Packet{
    public static $ID = 0x01;

    public $pingID;

    public function encode(){
        parent::encode();
        $this->buffer .= Binary::writeLong($this->pingID);
        $this->buffer .= RakLib::MAGIC;
    }

    public function decode(){
        parent::decode();
        $this->pingID = Binary::readLong($this->get(8));
        //magic
    }
}