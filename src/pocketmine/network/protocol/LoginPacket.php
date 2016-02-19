<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class LoginPacket extends DataPacket{
	const NETWORK_ID = Info::LOGIN_PACKET;

	public $username;
	public $protocol1;
	public $protocol2;
	public $clientId;

	public $clientUUID;
	public $serverAddress;
	public $clientSecret;

	public $skinName;
	public $skin = null;

	public function decode(){
		$this->username = $this->getString();
		$this->protocol1 = $this->getInt();
		$this->protocol2 = $this->getInt();
		if($this->protocol1 < Info::CURRENT_PROTOCOL){ //New fields!
			$this->setBuffer(null, 0); //Skip batch packet handling
			return;
		}
		$this->clientId = $this->getLong();
		$this->clientUUID = $this->getUUID();
		$this->serverAddress = $this->getString();
		$this->clientSecret = $this->getString();

		$this->skinName = $this->getString();
		$this->skin = $this->getString();
	}

	public function encode(){

	}

}
