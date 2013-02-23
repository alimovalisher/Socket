<?php
namespace Aysheka\Socket\Exception;

use Aysheka\Socket\Event\ExceptionEvent;
use Aysheka\Socket\Socket;
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

        $socket->getEventDispatcher()->dispatch(ExceptionEvent::getEventName(), new ExceptionEvent($socket, $this));
    }
}
