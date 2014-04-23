<?php

namespace Aysheka\Socket\Event\IO;

use Aysheka\Socket\Event\SocketEvent;

class WriteEvent extends SocketEvent
{
    protected static $name = 'aysheka.socket.event.io.write';
}
