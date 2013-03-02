<?php
namespace Aysheka\Socket\Server\Exception;

use Aysheka\Socket\Server;

class BindException extends ServerException
{
    function __construct(Server\Server $socket)
    {
        parent::__construct($socket, 'Can\'t bind to socket');
    }
}
