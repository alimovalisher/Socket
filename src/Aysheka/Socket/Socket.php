<?php
namespace Aysheka\Socket;

use Aysheka\Socket\Exception\SocketException;
use Aysheka\Socket\Exception\IOException;

class Socket
{
    const DOMAIN_PROTOCOL_IP4  = AF_INET;
    const DOMAIN_PROTOCOL_IP6  = AF_INET6;
    const DOMAIN_PROTOCOL_UNIX = AF_UNIX;

    const TYPE_SOCK_STREAM    = SOCK_STREAM;
    const TYPE_SOCK_DGRAM     = SOCK_DGRAM;
    const TYPE_SOCK_SEQPACKET = SOCK_SEQPACKET;
    const TYPE_SOCK_RAW       = SOCK_RAW;
    const TYPE_SOCK_RDM       = SOCK_RDM;

    const PROTOCOL_TCP = SOL_TCP;
    const PROTOCOL_UDP = SOL_UDP;

    private $domainProtocol = self::DOMAIN_PROTOCOL_IP4;
    private $type = self::TYPE_SOCK_STREAM;
    private $protocol = self::PROTOCOL_TCP;

    private $socket;

    /**
     * @description Available options: ['domainProtocol', 'type', 'protocol', 'connect']
     * @param array $properties
     *
     */
    public function __construct(array $properties = array())
    {
        if (isset($properties['domainProtocol'])) {
            $this->domainProtocol = $properties['domainProtocol'];
        }

        if (isset($properties['type'])) {
            $this->type = $properties['type'];
        }

        if (isset($properties['protocol'])) {
            $this->protocol = $properties['protocol'];
        }

        if ((isset($properties['connect']) && false === $properties['connect']) || !isset($properties['connect'])) {
            $this->socket = socket_create($this->domainProtocol, $this->type, $this->protocol);
        }
        if (false === $this->socket) {
            throw SocketException::cantOpenSocket();
        }
    }

    protected function getSocket()
    {
        return $this->socket;
    }

    protected function setSocket($socket)
    {
        $this->socket = $socket;
    }

    public function read($length = 1024)
    {
        if (false === ($data = socket_read($this->socket, $length))) {
            throw IOException::cantReadFromSocket();
        }
        return $data;
    }

    public function write($data)
    {
        if (!socket_write($this->socket, $data, strlen($data))) {
            throw IOException::cantWriteToSocket();
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        socket_close($this->socket);
    }


}
