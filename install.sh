#Advanced clear script for ClearSky :З

clear
echo '   ______ __                   _____  __         '
echo '  / ____// /___   ____ _ _____/ ___/ / /__ __  __'
echo ' / /    / // _ \ / __ `// ___/\__ \ / //_// / / /'
echo '/ /___ / //  __// /_/ // /   ___/ // ,<  / /_/ / '
echo '\____//_/ \___/ \__,_//_/   /____//_/|_| \__, /  '
echo '                                        /____/   '

sleep 2

echo "Please chose which PHP-binary you want to install"
echo "	1) Linux x86"
echo "	2) Linux x64"
echo -n "Number (e.g. 1): "
read a

case "$a" in 
	1 ) z="PHP_5.6.10_x86_Linux.tar.gz";;
	2 ) z="PHP_5.6.10_x86-64_Linux.tar.gz";;
	* ) z="x";;
esac

l="install_log/log"
le="install_log/log_errors"
lp="install_log/log_php"
lpe="install_log/log_php_errors"
w="install_log/log_wget"
wp="install_log/log_wget_php"

if [ $z == "x" ];then
	echo "Improperly selected! Restart the script, and then chose again."
	exit 1
else
	mkdir install_log
	echo "Installing ClearSky..."
	wget https://github.com/ClearSkyTeam/ClearSky/archive/master.zip >>./$w 2>>./$w
	chmod 777 master.zip >>./$l 2>>./$le
	unzip -o master.zip >>./$l 2>>./$le
	chmod 777 ClearSky-master >>./$l 2>>./$le
	cd ClearSky-master >>./$l 2>>./$le
	chmod 777 src >>../$l 2>>../$le
	cp -rf src .. >>../$l 2>>../$le
	cd .. >>../$l 2>>../$le
	rm -rf ClearSky-master >>./$l 2>>./$le
	rm -rf master.zip >>./$l 2>>./$le
	wget https://raw.githubusercontent.com/PocketMine/PocketMine-MP/master/start.sh >>./$l 2>>./$le
	chmod 777 start.sh >>./$l 2>>./$le
	echo
	
	echo 'Installing PHP binary...'
	wget https://bintray.com/artifact/download/pocketmine/PocketMine/$z >>./$wp 2>>./$wp
	chmod 777 $z >>./$lp 2>>./$lpe
	tar zxvf $z >>./$lp 2>>./$lpe
	rm -r $z >>./$lp 2>>./$lpe
	echo
	echo "ClearSky installed! Run ./start.sh (or ./st*) to start ClearSky."
fi
