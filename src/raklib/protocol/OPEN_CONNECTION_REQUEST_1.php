<?php
namespace raklib\protocol;

use raklib\Binary;









use raklib\RakLib;

class OPEN_CONNECTION_REQUEST_1 extends Packet{
    public static $ID = 0x05;

    public $protocol = RakLib::PROTOCOL;
    public $mtuSize;

    public function encode(){
        parent::encode();
        $this->buffer .= RakLib::MAGIC;
        $this->buffer .= \chr($this->protocol);
        $this->buffer .= \str_repeat(\chr(0x00), $this->mtuSize - 18);
    }

    public function decode(){
        parent::decode();
        $this->offset += 16; //Magic
        $this->protocol = \ord($this->get(1));
        $this->mtuSize = \strlen($this->get(\true)) + 18;
    }
}
