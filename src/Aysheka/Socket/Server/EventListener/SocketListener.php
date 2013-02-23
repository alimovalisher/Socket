<?php
namespace Aysheka\Socket\EventListener;

// TODO seems this class must be deleted
use Aysheka\Socket\Server\Event\ServerEvent;

class SocketListener
{

    function onClose(ServerEvent $event)
    {
        // Delete connection from server
    }
}
