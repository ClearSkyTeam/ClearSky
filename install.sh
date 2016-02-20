#Advanced clear script for ClearSky :З

clear
echo '   ______ __                   _____  __         '
echo '  / ____// /___   ____ _ _____/ ___/ / /__ __  __'
echo ' / /    / // _ \ / __ `// ___/\__ \ / //_// / / /'
echo '/ /___ / //  __// /_/ // /   ___/ // ,<  / /_/ / '
echo '\____//_/ \___/ \__,_//_/   /____//_/|_| \__, /  '
echo '                                        /____/   '

sleep 2
wget -q --tries=10 --timeout=20 --spider https://github.com
if [[ $? -eq 0 ]]; then
    echo "Please chose which version of MCPE server you want to install"
	echo "	1) 0.14.x"
	echo "	2) 0.13.x"
	echo -n "Number (e.g. 2): "
	read x
	
	echo "Also chose which PHP-binary you want to install"
	echo "	1) Linux x86"
	echo "	2) Linux x64"
	echo -n "Number (e.g. 1): "
	read z
	
	case "$x" in
		1 ) ver="master";;
		2 ) ver="0.13";;
		* ) z="x";;
	esac
	case "$z" in 
		1 ) bin="php5_linux_x86.tar.gz";;
		2 ) bin="php5_linux_x64.tar.gz";;
		* ) z="x";;
	esac

	l="install_log/log"
	le="install_log/log_errors"
	lp="install_log/log_php"
	lpe="install_log/log_php_errors"
	w="install_log/log_download"

	if [ $z == "x" ];then
		echo "Improperly selected! Restart the script, and then chose again."
		exit 1
	else
		echo -n "Do you want to enable auto-restarting server when stop/crash? (y/N): "
		read c
		echo '# If you want to do loop (auto-restarting server when stop/crash), change "no" to "yes"' > start.sh
		if [ $c == "y" ]||[ $c == "Y" ]; then
			echo 'DO_LOOP="yes"' >> start.sh
		else
			echo 'DO_LOOP="no"' >> start.sh
		fi
		echo >> start.sh
		mkdir install_log
		
		echo "Downloading install files..."
		wget https://github.com/ClearSkyTeam/ClearSky/archive/$ver\.zip >./$w 2>./$w
		wget -q -O - https://raw.githubusercontent.com/alex2534alex/ClearSky-INSTALL_FILES/master/start.sh  >> start.sh
		wget https://raw.githubusercontent.com/alex2534alex/ClearSky-INSTALL_FILES/master/$bin >>./$w 2>>./$w
		
		echo "Installing ClearSky..."
		chmod 777 $ver\.zip >./$l 2>./$le
		unzip -o $ver\.zip >>./$l 2>>./$le
		chmod 777 ClearSky-$ver >>./$l 2>>./$le
		cd ClearSky-$ver >>./$l 2>>./$le
		chmod 777 src >>../$l 2>>../$le
		cp -rf src .. >>../$l 2>>../$le
		cd .. >>../$l 2>>../$le
		rm -rf ClearSky-$ver >>./$l 2>>./$le
		rm -rf $ver\.zip >>./$l 2>>./$le
		chmod 777 start.sh >>./$l 2>>./$le
		
		echo "Installing PHP binary..."
		chmod 777 $bin >./$lp 2>./$lpe
		tar zxvf $bin >>./$lp 2>>./$lpe
		rm -r $bin >>./$lp 2>>./$lpe
		echo
		echo "ClearSky installation completed! Run ./start.sh (or ./st*) to start ClearSky."
	fi
else
        echo "You need to connect to the Internet for installing ClearSky"
fi
