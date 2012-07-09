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

    protected $socket;
    protected $data;

    public function __construct(Socket $socket, $data=null)
    {
        $this->socket = $socket;
        $this->data   = $data;
    }

    public function getSocket()
    {
        return $this->socket;
    }

    public function getData()
    {
        return $this->data;
    }
}
