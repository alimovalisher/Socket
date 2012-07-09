<?php
namespace Aysheka\Socket\Event;

use Symfony\Component\EventDispatcher\Event;
use Aysheka\Socket\Socket;

class SocketEvent extends Event
{
    const READ      = 'aysheka.socket.event.io.read';
    const WRITE     = 'aysheka.socket.event.io.write';
    const OPEN      = 'aysheka.socket.event.init.open';
    const CONNECT   = 'aysheka.socket.event.init.connect';
    const BIND      = 'aysheka.socket.event.init.bind';
    const CLOSE     = 'aysheka.socket.event.init.close';
    const EXCEPTION = 'aysheka.socket.event.exception';

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
