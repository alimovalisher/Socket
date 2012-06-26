<?php
namespace Aysheka\Socket;

use Aysheka\Socket\Exception\SocketException;
use Aysheka\Socket\Exception\IOException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Event\SocketEvent;

class Socket
{
    private $domainProtocol;
    private $type;
    private $protocol;
    private $socketResource;
    private $eventDispatcher;

    /**
     * @description Available options: ['domain.protocol', 'type', 'protocol']
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

    function open()
    {
        $this->socketResource = socket_create($this->domainProtocol->getType(), $this->type->getType(), $this->protocol->getType());

        if (false === $this->socketResource) {
            throw SocketException::cantOpenSocket();
        }
        $this->getEventDispatcher()->dispatch(SocketEvent::SOCKET_NEW_EVENT, new SocketEvent($this));
    }


    function read($length = 1024)
    {
        if (false === ($data = socket_read($this->getSocketResource(), $length))) {
            throw IOException::cantReadFromSocket();
        }
        return $data;
    }

    function write($data)
    {
        if (!socket_write($this->socketResource, $data, strlen($data))) {
            throw IOException::cantWriteToSocket();
        }
    }

    function __destruct()
    {
        $this->close();
    }

    function close()
    {
        if (is_resource($this->socketResource)) {
            socket_close($this->getSocketResource());
            $this->socketResource = null;
            $this->getEventDispatcher()->dispatch(SocketEvent::SOCKET_CLOSE_EVENT, new SocketEvent($this));
        }
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
    protected function getEventDispatcher()
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
