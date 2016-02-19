if(!(Test-Path .\php5\php.exe)){
	"Can't find an available PHP runtime"
	sleep 5
	exit
}
if(Test-Path .\ClearSky.phar){
	.\php5\php.exe ClearSky.phar
}elseif(Test-Path .\src\pocketmine\PocketMine.php){
	.\php5\php.exe .\src\pocketmine\PocketMine.php
}else{
	"Can't find an available ClearSky"
	sleep 5
	exit
}
