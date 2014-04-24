<?php
namespace Aysheka\Socket;

use Aysheka\Socket\Address\Address;
use Aysheka\Socket\Event\IO\ReadEvent;
use Aysheka\Socket\Event\IO\WriteEvent;
use Aysheka\Socket\Event\Init\CloseEvent;
use Aysheka\Socket\Event\Init\OpenEvent;
use Aysheka\Socket\Exception\IO\ReadException;
use Aysheka\Socket\Exception\Init\OpenException;
use Aysheka\Socket\Exception\IO\WriteException;
use Aysheka\Socket\Transport\Transport;
use Aysheka\Socket\Type\Type;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Socket
{
    /**
     * @var Address\Address
     */
    private $addressType;
    /**
     * Socket Type
     * @var Type\Type
     */
    private $socketType;
    /**
     * Transport
     * @var Transport\Transport
     */
    private $transport;
    /**
     * Socket resource
     * @var
     */
    private $socketResource;
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $eventDispatcher;


    function __construct(Address $addressType, Type $socketType, Transport $transport, EventDispatcherInterface $eventDispatcher)
    {
        $this->addressType     = $addressType;
        $this->socketType      = $socketType;
        $this->transport       = $transport;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Open socket
     * @throws Exception\Init\OpenException
     */
    function open()
    {
        $this->socketResource = socket_create($this->addressType->getType(), $this->socketType->getType(), $this->transport->getType());

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
            throw new WriteException($this, $data);
        }

        $this->getEventDispatcher()->dispatch(WriteEvent::getEventName(), new WriteEvent($this, $data));
    }

    /**
     * Close socket
     */
    function close()
    {
        if (is_resource($this->socketResource)) {
            socket_shutdown($this->socketResource, 2);
            socket_close($this->getSocketResource());
            $this->socketResource = null;
            $this->getEventDispatcher()->dispatch(CloseEvent::getEventName(), new CloseEvent($this));
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
    function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    function getAddressType()
    {
        return $this->addressType;
    }

    function getTransport()
    {
        return $this->transport;
    }

    function getSocketType()
    {
        return $this->socketType;
    }

}