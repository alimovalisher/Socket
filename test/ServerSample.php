<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Aysheka\Socket\Client;
use Aysheka\Socket\Socket;
use Aysheka\Socket\DomainProtocol;
use Aysheka\Socket\SocketProtocol;
use Aysheka\Socket\Type;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Event\ServerEvent;
use Aysheka\Socket\Event\SocketEvent;

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(ServerEvent::NEW_REQUEST, function (ServerEvent $event) {
    $socket = $event->getSocket();

    $msg = "HELO\n";
    $socket->write($msg);

    $socket->read();


    $socket->write('Block socket on 5 min');
//    $time = time();

//    while (time() - time() < 300) {
//        $socket->write('Olala');
//        sleep(1);
//    }
    sleep(300);
    $socket->write("Closing your socket\n");
    $socket->close();
});

$eventDispatcher->addListener(SocketEvent::OPEN, function (SocketEvent $event) {
    echo "Open\n";
});

$eventDispatcher->addListener(SocketEvent::CLOSE, function (SocketEvent $event) {
    echo "Close\n";
});

$eventDispatcher->addListener(SocketEvent::CONNECT, function (SocketEvent $event) {
    echo "Connect\n";
});

$eventDispatcher->addListener(SocketEvent::BIND, function (SocketEvent $event) {
    echo "Bind\n";
});

$eventDispatcher->addListener(SocketEvent::READ, function (SocketEvent $event) {
    echo "Read: " . trim($event->getData()) . "\n";
});

$eventDispatcher->addListener(SocketEvent::WRITE, function (SocketEvent $event) {
    echo "Write: " . trim($event->getData()) . "\n";
});

$server = new \Aysheka\Socket\Server('127.0.0.1', 8089, DomainProtocol::create(DomainProtocol::IP4), Type::create(Type::STREAM), SocketProtocol::create(\Aysheka\Socket\SocketProtocol::TCP), $eventDispatcher);
$server->create();