<?php

namespace Aysheka\Socket;

interface Listener
{
    public function accept(Socket $socket);
}
