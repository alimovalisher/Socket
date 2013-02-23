<?php
namespace Aysheka\Socket\Exception\Init;
use Aysheka\Socket\Socket;

class ConnectionException extends InitException
{
    function __construct(Socket $socket)
    {
        parent::__construct($socket, 'Could\'t connect to socket');
    }
}
