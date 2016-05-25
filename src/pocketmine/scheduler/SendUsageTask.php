<?php
namespace pocketmine\scheduler;

use pocketmine\network\protocol\Info;
use pocketmine\Server;
use pocketmine\utils\Utils;
use pocketmine\utils\VersionString;
use pocketmine\utils\UUID;

class SendUsageTask extends AsyncTask{

	const TYPE_OPEN = 1;
	const TYPE_STATUS = 2;
	const TYPE_CLOSE = 3;

	public $endpoint;
	public $data;

	public function __construct(Server $server, $type, $playerList = []){
		$endpoint = "http://" . $server->getProperty("anonymous-statistics.host", "stats.pocketmine.net") . "/";

		$data = [];
		$data["uniqueServerId"] = $server->getServerUniqueId()->toString();
		$data["uniqueMachineId"] = Utils::getMachineUniqueId()->toString();
		$data["uniqueRequestId"] = UUID::fromData($server->getServerUniqueId(), microtime(true))->toString();

		switch($type){
			case self::TYPE_OPEN:
				$data["event"] = "open";

				$version = new VersionString();

				$data["server"] = [
					"port" => $server->getPort(),
					"software" => $server->getName(),
					"fullVersion" => $version->get(true),
					"version" => $version->get(),
					"build" => $version->getBuild(),
					"api" => $server->getApiVersion(),
					"minecraftVersion" => $server->getVersion(),
					"protocol" => Info::CURRENT_PROTOCOL
				];

				$data["system"] = [
					"operatingSystem" => Utils::getOS(),
					"cores" => Utils::getCoreCount(),
					"phpVersion" => PHP_VERSION,
					"machine" => php_uname("a"),
					"release" => php_uname("r"),
					"platform" => php_uname("i")
				];

				$data["players"] = [
					"count" => 0,
					"limit" => $server->getMaxPlayers()
				];

				$plugins = [];

				foreach($server->getPluginManager()->getPlugins() as $p){
					$d = $p->getDescription();

					$plugins[$d->getName()] = [
						"name" => $d->getName(),
						"version" => $d->getVersion(),
						"enabled" => $p->isEnabled()
					];
				}

				$data["plugins"] = $plugins;

				break;
			case self::TYPE_STATUS:
				$data["event"] = "status";

				$data["server"] = [
					"ticksPerSecond" => $server->getTicksPerSecondAverage(),
					"tickUsage" => $server->getTickUsageAverage(),
					"ticks" => $server->getTick()
				];


				//This anonymizes the user ids so they cannot be reversed to the original
				foreach($playerList as $k => $v){
					$playerList[$k] = md5($v);
				}

				$players = [];
				foreach($server->getOnlinePlayers() as $p){
					if($p->isOnline()){
						$players[] = md5($p->getUniqueId()->toBinary());
					}
				}

				$data["players"] = [
					"count" => count($players),
					"limit" => $server->getMaxPlayers(),
					"currentList" => $players,
					"historyList" => array_values($playerList)
				];

				$info = Utils::getMemoryUsage(true);
				$data["system"] = [
					"mainMemory" => $info[0],
					"totalMemory" => $info[1],
					"availableMemory" => $info[2],
					"threadCount" => Utils::getThreadCount()
				];

				break;
			case self::TYPE_CLOSE:
				$data["event"] = "close";
				$data["crashing"] = $server->isRunning();
				break;
		}

		$this->endpoint = $endpoint . "api/post";
		$this->data = json_encode($data/*, JSON_PRETTY_PRINT*/);
	}

	public function onRun(){
		try{
			Utils::postURL($this->endpoint, $this->data, 5, [
				"Content-Type: application/json",
				"Content-Length: ". strlen($this->data)
			]);
		}catch(\Throwable $e){

		}
	}
}
