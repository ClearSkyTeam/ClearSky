<?php
namespace raklib\protocol;

use raklib\Binary;









class CLIENT_HANDSHAKE_DataPacket extends Packet{
    public static $ID = 0x13;

    public $address;
    public $port;
    
    public $systemAddresses = [];
    
    public $sendPing;
    public $sendPong;

    public function encode(){
        
    }

    public function decode(){
        parent::decode();
        $this->getAddress($this->address, $this->port);
         for($i = 0; $i < 10; ++$i){
			$this->getAddress($addr, $port, $version);
			$this->systemAddresses[$i] = [$addr, $port, $version];
		}
		
        $this->sendPing = Binary::readLong($this->get(8));
        $this->sendPong = Binary::readLong($this->get(8));
    }
}
