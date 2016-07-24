<?php
namespace pocketmine\wizard;


class InstallerLang{
	public static $languages = [
		"eng" => "English",
		"esp" => "Español",
		"zhs" => "中文",
		"jpn" => "日本語",
		//"ru" => "Pyccĸий",
		"deu" => "Deutsch",
		//"vi" => "Tiếng Việt",
		//"ko" => "한국어",
		//"nl" => "Nederlands",
		//"fr" => "Français",
		//"it" => "Italiano",
		//"lv" => "Latviešu",
		//"ms" => "Melayu",
		//"no" => "Norsk",
		//"pt" => "Português",
		//"sv" => "Svenska",
		//"fi" => "Suomi",
		//"tr" => "Türkçe",
		//"et" => "Eesti",
	];
	private $texts = [];
	private $lang;
	private $langfile;

	public function __construct($lang = ""){
		if(file_exists(\pocketmine\PATH . "src/pocketmine/lang/Installer/" . $lang . ".ini")){
			$this->lang = $lang;
			$this->langfile = \pocketmine\PATH . "src/pocketmine/lang/Installer/" . $lang . ".ini";
		}else{
			$files = [];
			foreach(new \DirectoryIterator(\pocketmine\PATH . "src/pocketmine/lang/Installer/") as $file){
				if($file->getExtension() === "ini" and substr($file->getFilename(), 0, 2) === $lang){
					$files[$file->getFilename()] = $file->getSize();
				}
			}

			if(count($files) > 0){
				arsort($files);
				reset($files);
				$l = key($files);
				$l = substr($l, 0, -4);
				$this->lang = isset(self::$languages[$l]) ? $l : $lang;
				$this->langfile = \pocketmine\PATH . "src/pocketmine/lang/Installer/" . $l . ".ini";
			}else{
				$this->lang = "eng";
				$this->langfile = \pocketmine\PATH . "src/pocketmine/lang/Installer/eng.ini";
			}
		}

		$this->loadLang(\pocketmine\PATH . "src/pocketmine/lang/Installer/eng.ini", "eng");
		if($this->lang !== "eng"){
			$this->loadLang($this->langfile, $this->lang);
		}
		
	}

	public function getLang(){
		return ($this->lang);
	}

	public function loadLang($langfile, $lang = "eng"){
		$this->texts[$lang] = [];
		$texts = explode("\n", str_replace(["\r", "\\/\\/"], ["", "//"], file_get_contents($langfile)));
		foreach($texts as $line){
			$line = trim($line);
			if($line === ""){
				continue;
			}
			$line = explode("=", $line);
			$this->texts[$lang][trim(array_shift($line))] = trim(str_replace(["\\n", "\\N",], "\n", implode("=", $line)));
		}
	}

	public function get($name, $search = [], $replace = []){
		if(!isset($this->texts[$this->lang][$name])){
			if($this->lang !== "eng" and isset($this->texts["eng"][$name])){
				return $this->texts["eng"][$name];
			}else{
				return $name;
			}
		}elseif(count($search) > 0){
			return str_replace($search, $replace, $this->texts[$this->lang][$name]);
		}else{
			return $this->texts[$this->lang][$name];
		}
	}

	public function __get($name){
		return $this->get($name);
	}

}
