<?php
namespace raklib\protocol;

#ifndef COMPILE
use raklib\Binary;
#endif


abstract class AcknowledgePacket extends Packet{
    /** @var int[] */
    public $packets = [];

    public function encode(){
        parent::encode();
        $payload = "";
        \sort($this->packets, SORT_NUMERIC);
        $count = \count($this->packets);
        $records = 0;

        if($count > 0){
            $pointer = 1;
            $start = $this->packets[0];
            $last = $this->packets[0];

            while($pointer < $count){
                $current = $this->packets[$pointer++];
                $diff = $current - $last;
                if($diff === 1){
                    $last = $current;
                }elseif($diff > 1){ //Forget about duplicated packets (bad queues?)
                    if($start === $last){
                        $payload .= "\x01";
                        $payload .= \substr(\pack("V", $start), 0, -1);
                        $start = $last = $current;
                    }else{
                        $payload .= "\x00";
                        $payload .= \substr(\pack("V", $start), 0, -1);
                        $payload .= \substr(\pack("V", $last), 0, -1);
                        $start = $last = $current;
                    }
                    ++$records;
                }
            }

            if($start === $last){
                $payload .= "\x01";
                $payload .= \substr(\pack("V", $start), 0, -1);
            }else{
                $payload .= "\x00";
                $payload .= \substr(\pack("V", $start), 0, -1);
                $payload .= \substr(\pack("V", $last), 0, -1);
            }
            ++$records;
        }

        $this->buffer .= \pack("n", $records);
        $this->buffer .= $payload;
    }

    public function decode(){
        parent::decode();
        $count = \unpack("n", $this->get(2))[1];
        $this->packets = [];
        $cnt = 0;
        for($i = 0; $i < $count and !$this->feof() and $cnt < 4096; ++$i){
            if(\ord($this->get(1)) === 0){
                $start = \unpack("V", $this->get(3) . "\x00")[1];
                $end = \unpack("V", $this->get(3) . "\x00")[1];
                if(($end - $start) > 512){
                    $end = $start + 512;
                }
                for($c = $start; $c <= $end; ++$c){
                    $this->packets[$cnt++] = $c;
                }
            }else{
                $this->packets[$cnt++] = \unpack("V", $this->get(3) . "\x00")[1];
            }
        }
    }

	public function clean(){
		$this->packets = [];
		return parent::clean();
	}
}