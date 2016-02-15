<?php
namespace raklib\protocol;

use raklib\Binary;
#include <rules/RakLibPacket.h>


class UNCONNECTED_PING_OPEN_CONNECTIONS extends UNCONNECTED_PING{
    public static $ID = 0x02;
}