<?php
namespace Aysheka\Socket;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Exception\SocketException;
use Aysheka\Socket\Exception\Server\BindException;
use Aysheka\Socket\Exception\Server\ListenException;
use Aysheka\Socket\Event\ServerEvent;
use Aysheka\Socket\Event\SocketEvent;

class Server extends Socket
{
    private $port;
    private $ip;
    private $running;

    function __construct($ip, $port, DomainProtocol $domainProtocol, Type $socketType, SocketProtocol $socketProtocol, EventDispatcher $eventDispatcher)
    {
        parent::__construct($domainProtocol, $socketType, $socketProtocol, $eventDispatcher);

        $this->ip   = $ip;
        $this->port = $port;
    }

    /**
     * Stop server (this method only change server "running" status"
     */
    function stop()
    {
        $this->running = false;
    }

    /**
     * Start server (this method only change server "running" status"
     */
    function start()
    {
        $this->running = true;
    }

    /**
     * Create server
     *  - bind to port
     *  - listen port
     * @throws Exception\Server\ListenException
     * @throws Exception\Server\BindException
     */
    function create()
    {
        $this->open();
        $serverSocket = $this->getSocketResource();

        if (!socket_bind($serverSocket, $this->ip, $this->port)) {
            throw new BindException($this);
        }


        $this->getEventDispatcher()->dispatch(SocketEvent::BIND, new SocketEvent($this));


        if (!socket_listen($serverSocket)) {
            throw new ListenException($this);
        }

//        socket_set_nonblock($serverSocket);

        $this->start();

        while ($this->running) {
            if (false !== ($clientSocket = socket_accept($serverSocket))) {
                $socket = new Socket($this->getDomainProtocol(), $this->getType(), $this->getProtocol(), $this->getEventDispatcher());
                $socket->setSocketResource($clientSocket);
                $socket->getEventDispatcher()->dispatch(ServerEvent::NEW_REQUEST, new ServerEvent($socket, $this));
            }

            sleep(3);
        }
    }

}
