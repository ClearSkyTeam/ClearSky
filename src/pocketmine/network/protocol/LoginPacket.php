<?php
namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class LoginPacket extends DataPacket {
	const NETWORK_ID = Info::LOGIN_PACKET;
	public $username;
	public $protocol;
	public $idk;
	public $clientId;
	public $clientUUID;
	public $serverAddress;
	public $clientSecret;
	public $slim = false;
	public $skinName;
	// for 0.15
	const MAGIC_NUMBER = 113;
	public $unknown3Bytes;   // terra incognita
	public $unknown4Bytes;   // terra incognita
	public $chainsDataLength;
	public $chains;
	public $playerDataLength;
	public $playerData;
	public $strangeData;   // terra incognita
	
	public $additionalChar = "";
	public $isValidProtocol = true;
	
	private function getFromString(&$body, $len) {
		$res = substr($body, 0, $len);
		$body = substr($body, $len);
		return $res;
	}
	
	public function decode(){	
		$addCharNumber = $this->getByte();
		if($addCharNumber > 0){
			$this->additionalChar = chr($addCharNumber);
		}
		if($addCharNumber == 0xfe){			
			$this->protocol = $this->getInt();			
			$bodyLength = $this->getInt();
			$body =  \zlib_decode($this->get($bodyLength));
			$this->chainsDataLength = Binary::readLInt($this->getFromString($body, 4));
			$this->chains = json_decode($this->getFromString($body, $this->chainsDataLength), true);
			
			
			$this->playerDataLength = Binary::readLInt($this->getFromString($body, 4));
			$this->playerData = $this->getFromString($body, $this->playerDataLength);
			$this->chains['data'] = array();
			$index = 0;			
			foreach ($this->chains['chain'] as $key => $jwt) {
				$data = self::load($jwt);
				if(isset($data['extraData'])) {
					$dataIndex = $index;
				}
				$this->chains['data'][$index] = $data;
				$index++;
			}
		
			$this->playerData = self::load($this->playerData);
			$this->username = $this->chains['data'][$dataIndex]['extraData']['displayName'];
			$this->clientId = $this->chains['data'][$dataIndex]['extraData']['identity'];
			if(isset($this->chains['data'][$dataIndex]['extraData']['XUID'])) {
				$this->clientUUID = UUID::fromBinary($this->chains['data'][$dataIndex]['extraData']['XUID']);
			}else{
				$this->clientUUID = UUID::fromBinary(substr($this->playerData['ClientRandomId'], 0, 16));
			}
			$this->identityPublicKey = $this->chains['data'][$dataIndex]['identityPublicKey'];
			
			$this->serverAddress = $this->playerData['ServerAddress'];
			$this->skinName = $this->playerData['SkinId'];
			$this->skin = base64_decode($this->playerData['SkinData']);
		}else{
			$this->username = $this->getString();
			$this->protocol = $this->getInt();
			$this->idk = $this->getInt();
			$this->clientId = $this->getLong();
			$this->clientUUID = $this->getUUID();
			$this->serverAddress = $this->getString();
			$this->clientSecret = $this->getString();
			$this->skinName = $this->getString();
			$this->skin = $this->getString();
		}
		var_dump($this->protocol);
		var_dump($this->idk);
	}

	public function encode(){

	}

	public function decodeToken($token){
		$tokens = explode(".", $token);
		list($headB64, $payloadB64, $sigB64) = $tokens;

		return json_decode(base64_decode($payloadB64), true);
	}
}
