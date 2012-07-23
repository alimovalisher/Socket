<?php
namespace Aysheka\Socket\Exception\Init;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Exception\Init\InitException;

class OpenException extends InitException
{
    function __construct(Socket $socket)
    {
        parent::__construct($socket, 'Can\'t open socket');
    }
}
