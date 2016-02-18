<?php
namespace raklib\protocol;

#include <rules/RakLibPacket.h>









use raklib\RakLib;

class OPEN_CONNECTION_REPLY_2 extends Packet{
    public static $ID = 0x08;

    public $serverID;
    public $clientAddress;
    public $clientPort;
    public $mtuSize;

    public function encode(){
        parent::encode();
        $this->put(RakLib::MAGIC);
        $this->putLong($this->serverID);
        $this->putAddress($this->clientAddress, $this->clientPort, 4);
        $this->putShort($this->mtuSize);
        $this->putByte(0); //server security
    }

    public function decode(){
        parent::decode();
        $this->offset += 16; //Magic
        $this->serverID = $this->getLong();
		$this->getAddress($this->clientAddress, $this->clientPort);
        $this->mtuSize = $this->getShort();
        //server security
    }
}
