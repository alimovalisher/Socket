<?php
namespace Aysheka\Socket\Server\Exception;

use Aysheka\Socket\Server;

class ListenException extends ServerException
{
    function __construct(Server $server)
    {
        parent::__construct($server, 'Cant listen socket');
    }
}
