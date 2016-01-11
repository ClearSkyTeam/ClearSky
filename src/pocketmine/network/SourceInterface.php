<?php
/**
 * Network-related classes
 */
namespace pocketmine\network;

use pocketmine\network\protocol\DataPacket;
use pocketmine\Player;

/**
 * Classes that implement this interface will be able to be attached to players
 */
interface SourceInterface{

	/**
	 * Sends a DataPacket to the interface, returns an unique identifier for the packet if $needACK is true
	 *
	 * @param Player     $player
	 * @param DataPacket $packet
	 * @param bool       $needACK
	 * @param bool       $immediate
	 *
	 * @return int
	 */
	public function putPacket(Player $player, DataPacket $packet, $needACK = false, $immediate = true);

	/**
	 * Terminates the connection
	 *
	 * @param Player $player
	 * @param string $reason
	 *
	 */
	public function close(Player $player, $reason = "unknown reason");

	/**
	 * @param string $name
	 */
	public function setName($name);

	/**
	 * @return bool
	 */
	public function process();

	public function shutdown();

	public function emergencyShutdown();

}