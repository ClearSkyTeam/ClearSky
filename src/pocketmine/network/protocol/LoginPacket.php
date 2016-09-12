<?php
namespace pocketmine\network\protocol;
#include <rules/DataPacket.h>

//TERRA INCOGNITA
class LoginPacket extends DataPacket{
	const NETWORK_ID = Info::LOGIN_PACKET;
	public $username;
	public $protocol;
	public $clientUUID;
	public $clientId;
	public $identityPublicKey;
	public $serverAddress;
	public $skinId;
	public $skin = null;
	public $webtokens = [];
	public $isXbox = false;
	public $xboxData = null;
	public function decode(){
		$this->protocol = $this->getInt();
		if(!in_array($this->protocol, Info::ACCEPT_PROTOCOL)){
			return; //Do not attempt to decode for non-accepted protocols
		}
		$str = zlib_decode($this->get($this->getInt()), 1024 * 1024 * 64); //Max 64MB
		$this->setBuffer($str, 0);
		$chainData = json_decode($this->get($this->getLInt()));
		foreach ($chainData->{"chain"} as $chain){
			$webtoken = $this->decodeToken($chain);
			$this->webtokens[] = $webtoken;
			if(isset($webtoken["iss"])){
				$this->isXbox = true;
				$this->xboxData["iss"] = $webtoken["iss"];
			}
			if(isset($webtoken["extraData"])){
				if(isset($webtoken["extraData"]["displayName"])){
					$this->username = $webtoken["extraData"]["displayName"];
				}
				if(isset($webtoken["extraData"]["identity"])){
					$this->clientUUID = $webtoken["extraData"]["identity"];
				}
				if(isset($webtoken["extraData"]["xuid"]) && $this->isXbox){
					$this->xboxData["xuid"] = $webtoken["extraData"]["xuid"];
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