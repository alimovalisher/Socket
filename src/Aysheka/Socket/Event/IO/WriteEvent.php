<?php

namespace Aysheka\Socket\Event\IO;

use Aysheka\Socket\Event\SocketEvent;

class WriteEvent extends SocketEvent
{
    static function getEventName()
    {
        return 'aysheka.socket.event.io.write';
    }
}
