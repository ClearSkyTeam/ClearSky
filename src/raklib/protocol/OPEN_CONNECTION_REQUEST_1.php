<?php
namespace raklib\protocol;

#include <rules/RakLibPacket.h>









use raklib\RakLib;

class OPEN_CONNECTION_REQUEST_1 extends Packet{
    public static $ID = 0x05;

    public $protocol = RakLib::PROTOCOL;
    public $mtuSize;

    public function encode(){
        parent::encode();
        $this->put(RakLib::MAGIC);
        $this->putByte($this->protocol);
        $this->put(str_repeat(chr(0x00), $this->mtuSize - 18));
    }

    public function decode(){
        parent::decode();
        $this->offset += 16; //Magic
        $this->protocol = $this->getByte();
        $this->mtuSize = strlen($this->get(true)) + 18;
    }
}
