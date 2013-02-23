<?php
namespace Aysheka\Socket;

use Aysheka\Socket\Address\Address;
use Aysheka\Socket\Event\IO\ReadEvent;
use Aysheka\Socket\Event\IO\WriteEvent;
use Aysheka\Socket\Event\Init\OpenEvent;
use Aysheka\Socket\Exception\IO\ReadException;
use Aysheka\Socket\Exception\Init\OpenException;
use Aysheka\Socket\Protocol\Protocol;
use Aysheka\Socket\Type\Type;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Socket
{
    private $domainProtocol;
    private $type;
    private $protocol;
    private $socketResource;
    private $eventDispatcher;


    /**
     * @param \Aysheka\Socket\Address\Address|\Aysheka\Socket\Address\Address       $address
     * @param \Aysheka\Socket\Type\Type|\Aysheka\Socket\Type\Type                   $socketType
     * @param \Aysheka\Socket\Protocol\Protocol|\Aysheka\Socket\Protocol\Protocol   $protocol
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface           $eventDispatcher
     */
    function __construct(Address $address, Type $socketType, Protocol $protocol, EventDispatcherInterface $eventDispatcher)
    {
        $this->domainProtocol  = $address;
        $this->type            = $socketType;
        $this->protocol        = $protocol;
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

        $this->getEventDispatcher()->dispatch(OpenEvent::getEventName(), new OpenEvent($this));

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

        $this->getEventDispatcher()->dispatch(ReadEvent::getEventName(), new ReadEvent($this, $data));

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

        $this->getEventDispatcher()->dispatch(WriteEvent::getEventName(), new WriteEvent($this, $data));
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
     * @return EventDispatcherInterface
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
