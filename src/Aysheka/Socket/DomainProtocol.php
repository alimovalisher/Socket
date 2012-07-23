<?php
namespace Aysheka\Socket;

class DomainProtocol
{
    const IP4  = AF_INET;
    const IP6  = AF_INET6;
    const UNIX = AF_UNIX;

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
