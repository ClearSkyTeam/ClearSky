DIR="$(cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd)"
cd "$DIR"

# Loop toggling switch
# Set to DO_LOOP="no" if you want don't want it to loop, set to DO_LOOP="yes" if you want it to loop
DO_LOOP="no"

#######################################################################################
# ERROR: Restricted area - access denied. Don't try to edit anything below this line! #
#######################################################################################

while getopts "p:f:l" OPTION 2> /dev/null; do
	case ${OPTION} in
		p)
			PHP_BINARY="$OPTARG"
			;;
		f)
			POCKETMINE_FILE="$OPTARG"
			;;
		l)
			DO_LOOP="yes"
			;;
		\?)
			break
			;;
	esac
done

if [ "$PHP_BINARY" == "" ]; then
	if [ -f ./bin/php5/bin/php ]; then
		export PHPRC=""
		PHP_BINARY="./bin/php5/bin/php"
	elif [ type php 2>/dev/null ]; then
		PHP_BINARY=$(type -p php)
	else
		echo "Couldn't find a working PHP binary, please use the installer."
		exit 7
	fi
fi

if [ "$POCKETMINE_FILE" == "" ]; then
	if [ -f ./ClearSky.phar ]; then
		POCKETMINE_FILE="./ClearSky.phar"
	elif [ -f ./src/pocketmine/PocketMine.php ]; then
		POCKETMINE_FILE="./src/pocketmine/PocketMine.php"
	else
		echo "Couldn't find a valid ClearSky installation. If you have recently upgraded, ensure that you have renamed PocketMine-MP.phar to ClearSky.phar"
		exit 7
	fi
fi

LOOPS=0

set +e
while [ "$LOOPS" -eq 0 ] || [ "$DO_LOOP" == "yes" ]; do
	if [ "$DO_LOOP" == "yes" ]; then
		"$PHP_BINARY" "$POCKETMINE_FILE" $@
	else
		exec "$PHP_BINARY" "$POCKETMINE_FILE" $@
	fi
	((LOOPS++))
done

if [ ${LOOPS} -gt 1 ]; then
	echo "Restarted $LOOPS times"
fi
