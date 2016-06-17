<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class LoginPacket extends DataPacket{
	const NETWORK_ID = Info::LOGIN_PACKET;

	public $username;
	public $protocol;

	public $clientUUID;
	public $clientId;
	public $identityPublicKey;
	public $serverAddress;
	public $additionalChar;

	public $skinID;
	public $skin = null;

	public function decode(){
		$addCharNumber = $this->getByte();
		if($addCharNumber > 0) {
			$this->additionalChar = chr($addCharNumber);
		}
		$this->protocol = $this->getInt();

		$str = zlib_decode($this->get($this->getInt()), 1024 * 1024 * 64); //Max 64MB
		$this->setBuffer($str, 0);

		$chainData = json_decode($this->get($this->getLInt()));
		foreach ($chainData->{"chain"} as $chain){
			$webtoken = $this->decodeToken($chain);
			if(isset($webtoken["extraData"])){
				if(isset($webtoken["extraData"]["displayName"])){
					$this->username = $webtoken["extraData"]["displayName"];
				}
				if(isset($webtoken["extraData"]["identity"])){
					$this->clientUUID = $webtoken["extraData"]["identity"];
				}
				if(isset($webtoken["identityPublicKey"])){
					$this->identityPublicKey = $webtoken["identityPublicKey"];
				}
			}
		}

		$skinToken = $this->decodeToken($this->get($this->getLInt()));
		if(isset($skinToken["ClientRandomId"])){
			$this->clientId = $skinToken["ClientRandomId"];
		}
		if(isset($skinToken["ServerAddress"])){
			$this->serverAddress = $skinToken["ServerAddress"];
		}
		if(isset($skinToken["SkinData"])){
			$this->skin = base64_decode($skinToken["SkinData"]);
		}
		if(isset($skinToken["SkinId"])){
			$this->skinId = $skinToken["SkinId"];
		}
	}

	public function encode(){

	}

	public function decodeToken($token){
		$tokens = explode(".", $token);
		list($headB64, $payloadB64, $sigB64) = $tokens;

		return json_decode(base64_decode($payloadB64), true);
	}
}
