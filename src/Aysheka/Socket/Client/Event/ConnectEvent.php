<?php

namespace Aysheka\Socket\Client\Event;

use Aysheka\Socket\Event\SocketEvent;

class ConnectEvent extends SocketEvent
{
    protected static $name = 'aysheka.socket.event.init.connect';
}
