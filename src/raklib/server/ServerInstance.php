<?php
namespace raklib\server;

use raklib\protocol\EncapsulatedPacket;

interface ServerInstance{

    /**
     * @param string     $identifier
     * @param string     $address
     * @param int        $port
     * @param string|int $clientID
     */
    public function openSession($identifier, $address, $port, $clientID);

    /**
     * @param string $identifier
     * @param string $reason
     */
    public function closeSession($identifier, $reason);

    /**
     * @param string             $identifier
     * @param EncapsulatedPacket $packet
     * @param int                $flags
     */
    public function handleEncapsulated($identifier, EncapsulatedPacket $packet, $flags);

    /**
     * @param string $address
     * @param int    $port
     * @param string $payload
     */
    public function handleRaw($address, $port, $payload);

    /**
     * @param string $identifier
     * @param int    $identifierACK
     */
    public function notifyACK($identifier, $identifierACK);

    /**
     * @param string $option
     * @param string $value
     */
    public function handleOption($option, $value);
}