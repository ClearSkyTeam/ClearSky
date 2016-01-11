<?php
namespace raklib\protocol;

use raklib\Binary;










use raklib\RakLib;

class UNCONNECTED_PONG extends Packet{
    public static $ID = 0x1c;

    public $pingID;
    public $serverID;
    public $serverName;

    public function encode(){
        parent::encode();
        $this->buffer .= Binary::writeLong($this->pingID);
        $this->buffer .= Binary::writeLong($this->serverID);
        $this->buffer .= RakLib::MAGIC;
        $this->putString($this->serverName);
    }

    public function decode(){
        parent::decode();
        $this->pingID = Binary::readLong($this->get(8));
        $this->serverID = Binary::readLong($this->get(8));
        $this->offset += 16; //magic
        $this->serverName = $this->getString();
    }
}
