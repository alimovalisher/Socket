<?php
namespace Aysheka\Socket\Exception;
use Aysheka\Socket\Socket;
use Aysheka\Socket\Event\SocketEvent;
use Exception;

class SocketException extends Exception
{
    protected $socket;
    protected $errorString;
    protected $errorNo;

    public function __construct(Socket $socket, $customMessage=null, $errorNo=null)
    {
        $this->socket = $socket;
        $this->errorNo = $errorNo ?: socket_last_error();
        $this->errorString = socket_strerror($this->errorNo);
        $msg = $this->errorString;

        if ($customMessage) {
            $msg = "$customMessage: $msg";
        }

        parent::__construct($msg);

        if ($socket->getEventDispatcher())
            $socket->getEventDispatcher()->dispatch(SocketEvent::EXCEPTION, new SocketEvent($socket, $this));
    }
}
