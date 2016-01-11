<?php

namespace raklib\protocol;

use raklib\Binary;









abstract class DataPacket extends Packet{

    /** @var EncapsulatedPacket[] */
    public $packets = [];

    public $seqNumber;

    public function encode(){
        parent::encode();
        $this->buffer .= substr(pack("V", $this->seqNumber), 0, -1);
        foreach($this->packets as $packet){
            $this->buffer .= $packet instanceof EncapsulatedPacket ? $packet->toBinary() : (string) $packet;
        }
    }

    public function length(){
        $length = 4;
        foreach($this->packets as $packet){
            $length += $packet instanceof EncapsulatedPacket ? $packet->getTotalLength() : strlen($packet);
        }

        return $length;
    }

    public function decode(){
        parent::decode();
        $this->seqNumber = unpack("V", $this->get(3) . "\x00")[1];

        while(!$this->feof()){
            $offset = 0;
			$data = substr($this->buffer, $this->offset);
            $packet = EncapsulatedPacket::fromBinary($data, false, $offset);
            $this->offset += $offset;
            if(strlen($packet->buffer) === 0){
                break;
            }
            $this->packets[] = $packet;
        }
    }

	public function clean(){
		$this->packets = [];
		$this->seqNumber = null;
		return parent::clean();
	}
}
