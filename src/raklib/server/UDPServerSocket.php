<?php

namespace raklib\server;

class UDPServerSocket{
    /** @var \Logger */
    protected $logger;
    protected $socket;

    public function __construct(\ThreadedLogger $logger, $port = 19132, $interface = "0.0.0.0"){
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        //socket_set_option($this->socket, SOL_SOCKET, SO_BROADCAST, 1); //Allow sending broadcast messages
        if(@socket_bind($this->socket, $interface, $port) === true){
            socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 0);
            $this->setSendBuffer(1024 * 1024 * 8)->setRecvBuffer(1024 * 1024 * 8);
        }else{
            $logger->critical("**** FAILED TO BIND TO " . $interface . ":" . $port . "!", true, true, 0);
            $logger->critical("Perhaps a server is already running on that port?", true, true, 0);
            exit(1);
        }
        socket_set_nonblock($this->socket);
    }

    public function getSocket(){
        return $this->socket;
    }

    public function close(){
        socket_close($this->socket);
    }

    /**
     * @param string &$buffer
     * @param string &$source
     * @param int    &$port
     *
     * @return int
     */
    public function readPacket(&$buffer, &$source, &$port){
        return socket_recvfrom($this->socket, $buffer, 65535, 0, $source, $port);
    }

    /**
     * @param string $buffer
     * @param string $dest
     * @param int    $port
     *
     * @return int
     */
    public function writePacket($buffer, $dest, $port){
        return socket_sendto($this->socket, $buffer, strlen($buffer), 0, $dest, $port);
    }

    /**
     * @param int $size
     *
     * @return $this
     */
    public function setSendBuffer($size){
        @socket_set_option($this->socket, SOL_SOCKET, SO_SNDBUF, $size);

        return $this;
    }

    /**
     * @param int $size
     *
     * @return $this
     */
    public function setRecvBuffer($size){
        @socket_set_option($this->socket, SOL_SOCKET, SO_RCVBUF, $size);

        return $this;
    }

}

?>