<?php

namespace Aysheka\Socket;

class Client extends Socket
{
    private $ip;
    private $port;

    public function __construct($ip, $port, array $parammeters = array())
    {
        parent::__construct($parammeters);
        $this->ip   = $ip;
        $this->port = $port;

        $socket = $this->getSocket();

        socket_connect($socket, $ip, $port);
    }

    public function send($data)
    {
        $socket = $this->getSocket();

        var_dump($this->read(64));

        socket_write($socket, $data, strlen($data));
    }
}
