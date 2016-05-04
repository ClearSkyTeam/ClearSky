<?php
namespace raklib\protocol;

class CLIENT_DISCONNECT_DataPacket extends Packet{
    public static $ID = 0x15;

    public function encode(){
        parent::encode();
    }

    public function decode(){
        parent::decode();
    }
}