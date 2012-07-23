<?php
namespace Aysheka\Socket;

use Aysheka\Socket\Exception\SocketException;
use Aysheka\Socket\Exception\IO\ReadException;
use Aysheka\Socket\Exception\IO\WriteException;
use Aysheka\Socket\Exception\Init\OpenException;
use Aysheka\Socket\Event\SocketEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Socket
{
    private $domainProtocol;
    private $type;
    private $protocol;
    private $socketResource;
    private $eventDispatcher;

    /**
     * @description Available options: ['domain.protocol', 'type', 'protocol']
     *
     * @param array $properties
     *
     */
    function __construct(DomainProtocol $domainProtocol, SocketType $socketType, SocketProtocol $socketProtocol, EventDispatcher $eventDispatcher)
    {
        $this->domainProtocol  = $domainProtocol;
        $this->type            = $socketType;
        $this->protocol        = $socketProtocol;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Open socket
     * @throws Exception\Init\OpenException
     */
    function open()
    {
        $this->socketResource = socket_create($this->domainProtocol->getType(), $this->type->getType(), $this->protocol->getType());

        if (false === $this->socketResource) {
            throw new OpenException($this);
        }

        $this->getEventDispatcher()->dispatch(SocketEvent::OPEN, new SocketEvent($this));

    }

    /**
     * Read data from socket
     *
     * @param int $length
     *
     * @return string
     * @throws Exception\IO\ReadException
     */
    function read($length = 1024)
    {
        if (false === ($data = socket_read($this->getSocketResource(), $length))) {
            throw new ReadException($this);
        }

        $this->getEventDispatcher()->dispatch(SocketEvent::READ, new SocketEvent($this, $data));

        return $data;
    }

    /**
     * Write data to socket
     *
     * @param $data
     *
     * @throws Exception\IO\ReadException
     */
    function write($data)
    {
        if (!socket_write($this->socketResource, $data, strlen($data))) {
            throw new ReadException($this, $data);
        }

        $this->getEventDispatcher()->dispatch(SocketEvent::WRITE, new SocketEvent($this, $data));
    }

    /**
     * Close socket
     */
    function close()
    {
        if (is_resource($this->socketResource)) {
            socket_close($this->getSocketResource());
            $this->socketResource = null;
            $this->getEventDispatcher()->dispatch(SocketEvent::CLOSE, new SocketEvent($this));
        }
    }

    function __destruct()
    {
        $this->close();
    }

    protected function getSocketResource()
    {
        return $this->socketResource;
    }

    protected function setSocketResource($socket)
    {
        $this->socketResource = $socket;
    }

    /**
     * @return EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    function getDomainProtocol()
    {
        return $this->domainProtocol;
    }

    function getProtocol()
    {
        return $this->protocol;
    }

    function getType()
    {
        return $this->type;
    }


}
