<?php

namespace Aysheka\Socket\Server\Event;


class BindEvent extends ServerEvent
{
    static function getEventName()
    {
        return 'aysheka.socket.server.event.bind';
    }

}
