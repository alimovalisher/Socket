<?php

namespace Aysheka\Socket;

use Aysheka\Socket\Exception\SocketException;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Client extends Socket
{
    private $ip;
    private $port;

    function __construct($ip, $port, DomainProtocol $domainProtocol, SocketType $socketType, SocketProtocol $socketProtocol, EventDispatcher $eventDispatcher)
    {
        parent::__construct($domainProtocol, $socketType, $socketProtocol, $eventDispatcher);
        $this->ip   = $ip;
        $this->port = $port;
    }

    function connect()
    {
        $this->open(); // open socket
        $socket = $this->getSocketResource();
        if (!socket_connect($socket, $this->ip, $this->port)) {
            throw SocketException::cantConnectToSocket();
        }
    }

    function send($data)
    {
        $this->write($data);
    }


}
