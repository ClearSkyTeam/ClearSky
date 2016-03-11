<?php
namespace pocketmine\updater;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;
use pocketmine\event\TranslationContainer;

class AutoUpdater{
	/** @var Server */
	protected $server;
	protected $endpoint;
	protected $hasUpdate = false;
	protected $updateInfo = null;
	protected $isupdating = false;

	public function __construct(Server $server, $endpoint){
		$this->server = $server;
		$this->endpoint = "http://$endpoint/job/".$this->getChannel()."/api/json";
		if($this->server->getPocketMineBuild() === "CuttingEdge"){
			$this->showCuttingEdge();
			$this->hasUpdate = false;
		}else{
			if($server->getProperty("auto-updater.enabled", true)){
				$this->check();
				if($this->hasUpdate()){
					if($this->server->getProperty("auto-updater.on-update.warn-console", true)){
						$this->showConsoleUpdate();
					}
				}
			}
		}
	}

	protected function check(){
		$response = Utils::getURL($this->endpoint, 4);
		$response = json_decode($response, true);
		if(!is_array($response)){
			echo"fail1";
			return;
		}

		$this->updateInfo = [
			"build" => $response["lastSuccessfulBuild"]["number"],
			"details_url" => "http://jenkins.clearskyteam.org/job/ClearSky/".$response["lastSuccessfulBuild"]["number"]."/changes",
			"download_url" => "http://jenkins.clearskyteam.org/job/ClearSky/".$response["lastSuccessfulBuild"]["number"]."/artifact/releases/ClearSky-master-%23".$response["lastSuccessfulBuild"]["number"].".phar"
		];
		
		$response = Utils::getURL("http://jenkins.clearskyteam.org/job/ClearSky/".$this->updateInfo['build']."/fingerprints/", 4);
		$t = explode('<a href="/fingerprint/', $response);
		if(!is_array($t))return;
		$j = explode('/">' ,$t[1]);
		if(!is_array($j))return;
		$fingerprint = $j[0];
		if($fingerprint == "")return;
		
		$this->updateInfo['fingerprint'] = $fingerprint;
		
		$this->checkUpdate();
	}

	/**
	 * @return bool
	 */
	public function hasUpdate(){
		return $this->hasUpdate;
	}
	
	public function doUpgrade(){
		if(!$this->isupdating){
			$this->isupdating = true;
			$this->server->getScheduler()->scheduleAsyncTask(new Upgrader($this->updateInfo['download_url'],$this->updateInfo['fingerprint']));
		}
	}
	
	public function downloadCompleteCallback(){
		$this->isupdating = false;
		$this->server->broadcastMessage(new TranslationContainer("commands.upgrade.finish"));
	}
	
	public function downloadFailCallback(){
		$this->isupdating = false;
		$this->server->broadcastMessage(new TranslationContainer("commands.upgrade.failed"));
	}
	
	public function showConsoleUpdate(){
		$logger = $this->server->getLogger();
		$newBuild = $this->updateInfo["build"];
		$currentBuild = $this->server->getPocketMineBuild();
		$logger->warning("----- ClearSky Auto Updater -----");
		$logger->warning("Your version of ".$this->getChannel()." Build #$currentBuild is out of date. Build #$newBuild was released.");
		if($this->updateInfo["details_url"] !== null){
			$logger->warning("Details: " . $this->updateInfo["details_url"]);
		}
		$logger->warning("Download: " . $this->updateInfo["download_url"]);
		$logger->warning("Fingerprint: " . $this->updateInfo["fingerprint"]);
		$logger->warning("You can run /dist-upgrade to update ClearSky");
		$logger->warning("----- -------------------------- -----");
	}

	public function showPlayerUpdate(Player $player){
		$player->sendMessage(TextFormat::DARK_PURPLE . "The version of ClearSky that this server is running is out of date. Please consider updating to the latest version.");
		$player->sendMessage(TextFormat::DARK_PURPLE . "Check the console for more details.");
	}
	
	protected function showCuttingEdge(){
		$logger = $this->server->getLogger();
		$logger->warning("----- ClearSky Auto Updater -----");
		$logger->warning("It appears you're running a CuttingEdge build, it is means you are using src or a custom build");
		$logger->warning("If you are running src for a production server , please use phar provide by our jenkins server for better performane");
		$logger->warning("If you are running a cunstom build , please remember ClearSky Team wont support this version");
		$logger->warning("----- -------------------------- -----");
	}
	
	public function getUpdateInfo(){
		return $this->updateInfo;
	}

	public function doCheck(){
		$this->check();
	}

	protected function checkUpdate(){
		if($this->updateInfo === null){
			return;
		}
		$currentBuild = $this->server->getPocketMineBuild();
		$newBuild = $this->updateInfo["build"];
		if($currentBuild < $newBuild){
			$this->hasUpdate = true;
		}else{
			$this->hasUpdate = false;
		}
		
	}

	public function getChannel(){
		$channel = strtolower($this->server->getProperty("auto-updater.preferred-channel", "ClearSky"));
		if($channel !== "ClearSky" and $channel !== "ClearSky-php7"){
			$channel = "ClearSky";
		}

		return $channel;
	}
}