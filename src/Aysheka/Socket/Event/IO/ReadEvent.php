<?php

namespace Aysheka\Socket\Event\IO;

use Aysheka\Socket\Event\SocketEvent;

class ReadEvent extends SocketEvent
{
    protected static $name = 'aysheka.socket.event.io.read';
}
