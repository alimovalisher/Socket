<?php
namespace Aysheka\Socket;
use Aysheka\Socket\Exception\SocketException;
use Aysheka\Socket\Exception\Init\BindException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Event\ServerEvent;
use Aysheka\Socket\Event\SocketEvent;

class Server extends Socket
{
    private $port;
    private $ip;

    function __construct($ip, $port, DomainProtocol $domainProtocol, SocketType $socketType, SocketProtocol $socketProtocol, $eventDispatcher=null)
    {
        parent::__construct($domainProtocol, $socketType, $socketProtocol, $eventDispatcher);

        $this->ip   = $ip;
        $this->port = $port;
    }


    function create()
    {
        $this->open();
        $serverSocket = $this->getSocketResource();

        if (!@socket_bind($serverSocket, $this->ip, $this->port)) {
            throw new BindException($this);
        }

        if ($this->getEventDispatcher())
            $this->getEventDispatcher()->dispatch(SocketEvent::BIND, new SocketEvent($this));

        if (!@socket_listen($serverSocket)) {
            throw new SocketException($this);
        }

        while (true) {
            if (false !== ($clientSocket = socket_accept($serverSocket))) {
                $socket = new Socket($this->getDomainProtocol(), $this->getType(), $this->getProtocol(), $this->getEventDispatcher());
                $socket->setSocketResource($clientSocket);
                if ($socket->getEventDispatcher())
                    $socket->getEventDispatcher()->dispatch(ServerEvent::NEW_REQUEST, new ServerEvent($socket));
            }
        }
    }

}
