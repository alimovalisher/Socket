<?php
namespace Aysheka\Socket;

class SocketType
{
    const STREAM    = SOCK_STREAM;
    const DGRAM     = SOCK_DGRAM;
    const SEQPACKET = SOCK_SEQPACKET;
    const RAW       = SOCK_RAW;
    const RDM       = SOCK_RDM;

    private $type;

    private function __construct($type)
    {
        $this->type = $type;
    }

    static function create($type)
    {
        return new self($type);
    }

    function getType()
    {
        return $this->type;
    }


}
