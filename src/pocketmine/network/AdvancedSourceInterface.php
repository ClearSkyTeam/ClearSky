<?php
/**
 * Network-related classes
 */
namespace pocketmine\network;

interface AdvancedSourceInterface extends SourceInterface{

	/**
	 * @param string $address
	 * @param int    $timeout Seconds
	 */
	public function blockAddress($address, $timeout = 300);

	/**
	 * @param Network $network
	 */
	public function setNetwork(Network $network);

	/**
	 * @param string $address
	 * @param int    $port
	 * @param string $payload
	 */
	public function sendRawPacket($address, $port, $payload);

}