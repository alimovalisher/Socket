<?php
namespace Aysheka\Socket\Event;

use Symfony\Component\EventDispatcher\Event;
use Aysheka\Socket\Socket;


abstract class SocketEvent extends Event
{
    protected $socket;
    protected $data;

    function __construct(Socket $socket, $data = null)
    {
        $this->socket = $socket;
        $this->data   = $data;
    }

    function getSocket()
    {
        return $this->socket;
    }

    function getData()
    {
        return $this->data;
    }

    abstract static function getEventName();
}
