<?php
namespace Aysheka\Socket\Server;

use Aysheka\Socket\Address\Address;
use Aysheka\Socket\Server\Event\BindEvent;
use Aysheka\Socket\Server\Event\NewConnectionEvent;
use Aysheka\Socket\Server\Exception\BindException;
use Aysheka\Socket\Server\Exception\ListenException;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Transport\Transport;
use Aysheka\Socket\Type\Type;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Server extends Socket
{
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $ip;
    /**
     * @var boolean
     */
    private $running;

    function __construct($ip, $port, Address $addressType, Type $socketType, Transport $transport, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($addressType, $socketType, $transport, $eventDispatcher);

        $this->ip   = $ip;
        $this->port = $port;
    }

    /**
     * Stop server (this method only change server "running" status")
     */
    function stop()
    {
        $this->running = false;
    }

    /**
     * Start server (this method only change server "running" status")
     */
    function start()
    {
        $this->running = true;
    }

    /**
     * Create server
     *  - bind to port
     *  - listen port
     * @throws ListenException
     * @throws BindException
     */
    function create($blocking = true)
    {
        $this->open();
        $serverSocket = $this->getSocketResource();

        if (!socket_bind($serverSocket, $this->getIp(), $this->getPort())) {
            throw new BindException($this);
        }

        $this->getEventDispatcher()->dispatch(BindEvent::getEventName(), new BindEvent($this, $this));

        if (!socket_listen($serverSocket)) {
            throw new ListenException($this);
        }

        if ($blocking) {
            socket_set_block($serverSocket);
        } else {
            socket_set_nonblock($serverSocket);
        }

        $this->start();

        while ($this->running) {

            $clientSocket = socket_accept($serverSocket);

            if (false == $clientSocket) {
                continue;
            }

            $socket = new Socket($this->getAddressType(), $this->getSocketType(), $this->getTransport(), $this->getEventDispatcher());
            $socket->setSocketResource($clientSocket);
            $socket->getEventDispatcher()->dispatch(NewConnectionEvent::getEventName(), new NewConnectionEvent($socket, $this));
        }
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
