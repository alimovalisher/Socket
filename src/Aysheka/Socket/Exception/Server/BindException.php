<?php
namespace Aysheka\Socket\Exception\Server;

use Aysheka\Socket\Server;

class BindException extends ServerException
{
    function __construct(Server $socket)
    {
        parent::__construct($socket, 'Can\'t bind to socket');
    }
}
