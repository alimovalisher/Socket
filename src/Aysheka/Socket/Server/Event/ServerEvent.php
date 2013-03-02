<?php
namespace Aysheka\Socket\Server\Event;

use Aysheka\Socket\Event\SocketEvent;
use Aysheka\Socket\Server;
use Aysheka\Socket\Socket;

abstract class ServerEvent extends SocketEvent
{
    protected $server;

    function __construct(Socket $socket, Server\Server $server)
    {
        parent::__construct($socket);
        $this->server = $server;
    }

    function getServer()
    {
        return $this->server;
    }
}
