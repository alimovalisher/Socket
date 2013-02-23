<?php

namespace Aysheka\Socket\Event\Init;

use Aysheka\Socket\Event\SocketEvent;

class OpenEvent extends SocketEvent
{
    static function getEventName()
    {
        return 'aysheka.socket.event.init.open';
    }

}
