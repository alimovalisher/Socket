<?php

namespace Aysheka\Socket\Server\Event;

class NewConnectionEvent extends ServerEvent
{
    static function getEventName()
    {
        return 'aysheka.socket.event.server.new_connection';
    }

}
