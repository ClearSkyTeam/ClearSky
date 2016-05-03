<?php
namespace raklib\protocol;

#include <rules/RakLibPacket.h>


use raklib\RakLib;

class OPEN_CONNECTION_REQUEST_2 extends Packet{
    public static $ID = 0x07;

    public $clientID;
	public $serverAddress;
    public $serverPort;
    public $mtuSize;

    public function encode(){
        parent::encode();
        $this->put(RakLib::MAGIC);
		$this->putAddress($this->serverAddress, $this->serverPort, 4);
        $this->putShort($this->mtuSize);
        $this->putLong($this->clientID);
    }

    public function decode(){
        parent::decode();
        $this->offset += 16; //Magic
		$this->getAddress($this->serverAddress, $this->serverPort);
        $this->mtuSize = $this->getShort();
        $this->clientID = $this->getLong();
    }
}
