<?php
namespace Aysheka\Socket;

class SocketProtocol
{
    const TCP = SOL_TCP;
    const UDP = SOL_UDP;

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
