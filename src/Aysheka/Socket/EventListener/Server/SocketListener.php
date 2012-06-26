<?php
namespace Aysheka\Socket\EventListener\Server;
use Aysheka\Socket\Event\ServerEvent;

class SocketListener
{

    function onClose(ServerEvent $event)
    {
        // Delete connection from server
    }
}
