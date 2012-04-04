<?php

namespace Aysheka\Socket;

use Aysheka\Socket\Exception\SocketException;

class Client extends Socket
{
    private $ip;
    private $port;

    public function __construct($ip, $port, array $parammeters = array())
    {
        parent::__construct($parammeters);
        $this->ip   = $ip;
        $this->port = $port;
    }

    public function connect()
    {
        $socket = $this->getSocket();
        if (!socket_connect($socket, $this->ip, $this->port)) {
            throw SocketException::cantConnectToSocket();
        }
    }

    public function send($data)
    {
        $this->write($data);
    }


}
