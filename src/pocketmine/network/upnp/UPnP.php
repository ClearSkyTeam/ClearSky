<?php
/**
 * UPnP port forwarding support. Only for Windows
 */
namespace pocketmine\network\upnp;

use pocketmine\utils\Utils;

abstract class UPnP{
	public static function PortForward($port){
		if(Utils::$online === false){
			return false;
		}
		if(Utils::getOS() != "win" or !class_exists("COM")){
			return false;
		}
		$port = (int) $port;
		$myLocalIP = gethostbyname(trim(`hostname`));
		try{
			$com = new \COM("HNetCfg.NATUPnP");
			if($com === false or !is_object($com->StaticPortMappingCollection)){
				return false;
			}
			$com->StaticPortMappingCollection->Add($port, "UDP", $port, $myLocalIP, true, "PocketMine-MP");
		}catch(\Throwable $e){
			return false;
		}

		return true;
	}

	public static function RemovePortForward($port){
		if(Utils::$online === false){
			return false;
		}
		if(Utils::getOS() != "win" or !class_exists("COM")){
			return false;
		}
		$port = (int) $port;
		try{
			$com = new \COM("HNetCfg.NATUPnP") or false;
			if($com === false or !is_object($com->StaticPortMappingCollection)){
				return false;
			}
			$com->StaticPortMappingCollection->Remove($port, "UDP");
		}catch(\Throwable $e){
			return false;
		}

		return true;
	}
}
