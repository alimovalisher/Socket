<?php

namespace Aysheka\Socket\Server\Event;

class NewConnectionEvent extends ServerEvent
{
    protected static $name = 'aysheka.socket.event.server.new_connection';
}
