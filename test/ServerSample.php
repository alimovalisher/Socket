<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Aysheka\Socket\Client;
use Aysheka\Socket\Socket;
use Aysheka\Socket\DomainProtocol;
use Aysheka\Socket\SocketProtocol;
use Aysheka\Socket\SocketType;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Event\ServerEvent;

class Listener
{
    public function onRequest(ServerEvent $event)
    {
        $socket = $event->getSocket();
        echo "Write to client\n";
        $msg = "Hello";
        $socket->write($msg);
        //        socket_write($socket->getSocket(), $msg, strlen($msg));

        echo "Ok\n";

        echo "Read from socket\n";

        //        $data = $socket->read(64);

        echo 'Client said: ';
        echo $socket->read(), "\n";

        echo "Finish work\n";
        $socket->write("Closing your socket\n");
        $socket->close();
        //        var_dump($data);
    }

}

$listener        = new Listener();
$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener(\Aysheka\Socket\Event\ServerEvent::NEW_REQUEST, array($listener, 'onRequest'));
$server = new \Aysheka\Socket\Server('127.0.0.1', 8088, DomainProtocol::create(DomainProtocol::IP4), SocketType::create(SocketType::STREAM), SocketProtocol::create(\Aysheka\Socket\SocketProtocol::TCP), $eventDispatcher);
$server->create();