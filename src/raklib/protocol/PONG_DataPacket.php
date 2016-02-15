<?php

namespace raklib\protocol;

use raklib\Binary;

class PONG_DataPacket extends Packet{
    public static $ID = 0x03;

    public $pingID;

    public function encode(){
        parent::encode();
        $this->buffer .= Binary::writeLong($this->pingID);
    }

    public function decode(){
        parent::decode();
        $this->pingID = Binary::readLong($this->get(8));
    }
}
