<?php
namespace Aysheka\Socket\Event;
use Aysheka\Socket\Server;
use Aysheka\Socket\Socket;

class ServerEvent extends SocketEvent
{
    const NEW_REQUEST = 'aysheka.socket.event.server.new_request';

    protected $server;

    function __construct(Socket $socket, Server $server)
    {
        parent::__construct($socket);
        $this->server = $server;
    }

    function getServer()
    {
        return $this->server;
    }
}
