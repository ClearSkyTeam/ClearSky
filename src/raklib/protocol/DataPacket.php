<?php
namespace raklib\protocol;

#include <rules/RakLibPacket.h>

abstract class DataPacket extends Packet{

    /** @var EncapsulatedPacket[] */
    public $packets = [];

    public $seqNumber;

    public function encode(){
        parent::encode();
        $this->putLTriad($this->seqNumber);
        foreach($this->packets as $packet){
            $this->put($packet instanceof EncapsulatedPacket ? $packet->toBinary() : (string) $packet);
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
        $this->seqNumber = $this->getLTriad();

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