<?php

namespace Aysheka\Socket\Server\Event;

class NewRequestEvent extends ServerEvent
{
    static function getEventName()
    {
        return 'aysheka.socket.event.server.new_request';
    }

}
