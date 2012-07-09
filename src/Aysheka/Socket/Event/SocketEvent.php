<?php
namespace Aysheka\Socket\Event;

use Symfony\Component\EventDispatcher\Event;
use Aysheka\Socket\Socket;

class SocketEvent extends Event
{
    const READ  = 'aysheka.socket.event.read';
    const WRITE = 'aysheka.socket.event.write';
    const OPEN  = 'aysheka.socket.event.open';
    const CLOSE = 'aysheka.socket.event.close';

    private $socket;

    function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    function getSocket()
    {
        return $this->socket;
    }


}
