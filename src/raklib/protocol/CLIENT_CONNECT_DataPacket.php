<?php
namespace raklib\protocol;

use raklib\Binary;









class CLIENT_CONNECT_DataPacket extends Packet{
    public static $ID = 0x09;

    public $clientID;
    public $sendPing;
    public $useSecurity = false;

    public function encode(){
        parent::encode();
        $this->buffer .= Binary::writeLong($this->clientID);
        $this->buffer .= Binary::writeLong($this->sendPing);
        $this->buffer .= chr($this->useSecurity ? 1 : 0);
    }

    public function decode(){
        parent::decode();
        $this->clientID = Binary::readLong($this->get(8));
        $this->sendPing = Binary::readLong($this->get(8));
        $this->useSecurity = ord($this->get(1)) > 0;
    }
}
