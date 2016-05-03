<?php
namespace raklib\protocol;

#include <rules/RakLibPacket.h>


use raklib\RakLib;

class UNCONNECTED_PONG extends Packet{
    public static $ID = 0x1c;

    public $pingID;
    public $serverID;
    public $serverName;

    public function encode(){
        parent::encode();
        $this->putLong($this->pingID);
        $this->putLong($this->serverID);
        $this->put(RakLib::MAGIC);
        $this->putString($this->serverName);
    }

    public function decode(){
        parent::decode();
        $this->pingID = $this->getLong();
        $this->serverID = $this->getLong();
        $this->offset += 16; //magic
        $this->serverName = $this->getString();
    }
}