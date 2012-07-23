<?php
namespace Aysheka\Socket\Exception\IO;
use Aysheka\Socket\Socket;

class ReadException extends IOException
{
    function __construct(Socket $socket)
    {
        parent::__construct($socket, 'Can\'t read from socket');
    }
}
