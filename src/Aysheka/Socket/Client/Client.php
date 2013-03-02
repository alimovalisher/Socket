<?php

namespace Aysheka\Socket\Client;

use Aysheka\Socket\Address\Address;
use Aysheka\Socket\Client\Event\ConnectEvent;
use Aysheka\Socket\Exception\Init\ConnectionException;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Transport\Transport;
use Aysheka\Socket\Type\Type;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Client Socket, provide method for working with client socket
 * @package Aysheka\Socket\Client
 */
class Client extends Socket
{
    /**
     * @var \Aysheka\Socket\Address\Address
     */
    private $ip;
    /**
     * @var int
     */
    private $port;

    function __construct($ip, $port, Address $addressType, Type $socketType, Transport $transport, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($addressType, $socketType, $transport, $eventDispatcher);
        $this->ip   = $ip;
        $this->port = $port;
    }

    /**
     * Connect to server
     * @throws ConnectionException
     */
    function connect()
    {
        $this->open(); // open socket
        $socket = $this->getSocketResource();

        if (!socket_connect($socket, $this->getIp(), $this->getPort())) {
            throw new ConnectionException($this);
        }

        $this->getEventDispatcher()->dispatch(ConnectEvent::getEventName(), new ConnectEvent($this));
    }

    protected function getIp()
    {
        return $this->ip;
    }

    protected function getPort()
    {
        return $this->port;
    }
}