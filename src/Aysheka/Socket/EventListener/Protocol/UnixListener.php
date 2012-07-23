<?php
namespace Aysheka\Socket\EventListener\Protocol;

use Aysheka\Socket\Event\SocketEvent;

// TODO remove file after closing unixsock
class UnixListener
{

    function onClose(SocketEvent $event)
    {
        // delete file
    }
}
