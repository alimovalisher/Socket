<?php
namespace Aysheka\Socket\Exception\IO;
use Aysheka\Socket\Socket;


class WriteException extends IOException
{
    function __construct(Socket $socket)
    {
        parent::__construct($socket, 'Can\'t write to socket');
    }
}
