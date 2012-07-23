<?php
namespace Aysheka\Socket\Exception;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Event\SocketEvent;
use Exception;

class SocketException extends Exception
{
    protected $socket;


    function __construct(Socket $socket, $message)
    {
        $this->socket       = $socket;
        $code               = socket_last_error();
        $socketErrorMessage = socket_strerror($code);

        parent::__construct("{$message}. {$socketErrorMessage}.", $code);

        $socket->getEventDispatcher()->dispatch(SocketEvent::EXCEPTION, new SocketEvent($socket, $this));
    }
}
