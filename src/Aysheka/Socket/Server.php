<?php
namespace Aysheka\Socket;
use Aysheka\Socket\Exception\SocketException;

class Server extends Socket
{
    private $port;
    private $ip;
    private $connections;

    public function __construct($ip, $port, array $parameters = array())
    {
        parent::__construct($parameters);

        $this->ip   = $ip;
        $this->port = $port;
    }

    public function listen(Listener $listener = null)
    {
        $currentSocket = $this->getSocket();


        if (!socket_bind($currentSocket, $this->ip, $this->port)) {
            throw SocketException::cantBindToSocket();
        }

        if (!socket_listen($currentSocket)) {
            throw SocketException::failed();
        }

        while (true) {
            if (false !== ($clientSocket = socket_accept($currentSocket))) {

                $socket = new Socket(array('connect' => false));
                $socket->setSocket($clientSocket);
                $this->connections[] = $socket;

                if (null !== $listener) {
                    $listener->accept($socket);
                } else {
                    $socket->close();
                }
            }
        }
    }
}
