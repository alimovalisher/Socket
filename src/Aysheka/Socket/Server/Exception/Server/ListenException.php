<?php
namespace Aysheka\Socket\Exception\Server;

use Aysheka\Socket\Server;

class ListenException extends ServerException
{
    function __construct(Server $server)
    {
        parent::__construct($server, 'Cant listen socket');
    }
}
