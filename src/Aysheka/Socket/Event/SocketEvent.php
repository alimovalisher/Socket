<?php
namespace Aysheka\Socket\Event;

use Symfony\Component\EventDispatcher\Event;
use Aysheka\Socket\Socket;

class SocketEvent extends Event
{
    const SOCKET_NEW_EVENT   = 'aysheka.socket.event.new';
    const SOCKET_CLOSE_EVENT = 'aysheka.socket.event.close';

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
