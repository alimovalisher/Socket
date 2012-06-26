<?php
namespace Aysheka\Socket;
use Aysheka\Socket\Exception\SocketException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Event\ServerEvent;

class Server extends Socket
{
    private $port;
    private $ip;

    function __construct($ip, $port, DomainProtocol $domainProtocol, SocketType $socketType, SocketProtocol $socketProtocol, EventDispatcher $eventDispatcher)
    {
        parent::__construct($domainProtocol, $socketType, $socketProtocol, $eventDispatcher);

        $this->ip   = $ip;
        $this->port = $port;
    }


    function create()
    {
        $this->open();
        $serverSocket = $this->getSocketResource();

        if (!socket_bind($serverSocket, $this->ip, $this->port)) {
            throw SocketException::cantBindToSocket();
        }

        if (!socket_listen($serverSocket)) {
            throw SocketException::failed();
        }

        while (true) {
            if (false !== ($clientSocket = socket_accept($serverSocket))) {
                $socket = new Socket($this->getDomainProtocol(), $this->getType(), $this->getProtocol(), $this->getEventDispatcher());
                $socket->setSocketResource($clientSocket);
                $this->getEventDispatcher()->dispatch(ServerEvent::NEW_REQUEST, new ServerEvent($socket));
            }
        }
    }

}
