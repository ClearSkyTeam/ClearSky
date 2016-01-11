<?php

namespace raklib\protocol;

use raklib\Binary;









class PING_DataPacket extends Packet{
    public static $ID = 0x00;

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
