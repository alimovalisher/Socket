<?php

namespace Aysheka\Socket\Event;

class ExceptionEvent extends SocketEvent
{
    static function getEventName()
    {
        return 'aysheka.socket.event.exception';
    }

}
