<?php
namespace Aysheka\Socket\Event;

use Symfony\Component\EventDispatcher\Event;
use Aysheka\Socket\Socket;


abstract class SocketEvent extends Event
{
    protected $socket;
    protected $data;
    protected static $name;

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

    static function getEventName(){
        return static::$name;
    }
}
