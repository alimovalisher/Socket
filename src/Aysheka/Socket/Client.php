<?php

namespace Aysheka\Socket;

use Aysheka\Socket\Exception\Init\ConnectException;
use Aysheka\Socket\Event\SocketEvent;
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

    /**
     * Connect to server
     * @throws Exception\Init\ConnectException
     */
    function connect()
    {
        $this->open(); // open socket
        $socket = $this->getSocketResource();

        if (!socket_connect($socket, $this->ip, $this->port)) {
            throw new ConnectException($this);
        }

        if ($this->getEventDispatcher())
            $this->getEventDispatcher()->dispatch(SocketEvent::CONNECT, new SocketEvent($this));
    }

    /**
     * Sent data to server
     *
     * @param $data
     */
    function send($data)
    {
        $this->write($data);
    }
}
