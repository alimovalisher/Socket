<?php

namespace Aysheka\Socket\Event\IO;

use Aysheka\Socket\Event\SocketEvent;

class ReadEvent extends SocketEvent
{
    static function getEventName()
    {
        return 'aysheka.socket.event.io.read';
    }

}
