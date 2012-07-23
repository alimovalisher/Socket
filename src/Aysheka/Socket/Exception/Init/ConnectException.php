<?php
namespace Aysheka\Socket\Exception\Init;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Exception\SocketException;

class ConnectException extends InitException
{
    function __construct(Socket $socket)
    {
        parent::__construct($socket, 'Can\'t connect to socket');
    }
}
