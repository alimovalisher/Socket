<?php
namespace Aysheka\Socket;

class Server extends Socket
{
    private $port;
    private $ip;
    private $connections;

    public function __construct($ip, $port, array $parameters = array())
    {
        parent::__construct($parameters);
        //        $socket = stream_socket_server('tcp://127.0.0.1:8087');
        //        $this->setSocket($socket);
        $this->ip   = $ip;
        $this->port = $port;
    }

    public function listen(Listener $listener = null)
    {
        $currentSocket = $this->getSocket();

        socket_bind($currentSocket, $this->ip, $this->port);
        socket_listen($currentSocket);
        socket_set_nonblock($currentSocket);

        while (true) {
            if (false !== ($newsocket = @socket_accept($currentSocket))) {
                $msg = "\nIm butch\n" .
                    "To quit, type 'quit'. To shut down the server type 'shutdown'.\n";
                socket_write($newsocket, $msg, strlen($msg));
                $socket              = new Socket(array('connect' => false));
                $this->connections[] = $socket;

                if (null !== $listener) {
                    $listener->accept($socket);
                }
            }
        }
    }
}
