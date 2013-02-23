<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Aysheka\Socket\Client;
use Aysheka\Socket\Type;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Event\SocketEvent;
use Aysheka\Socket\Server\Event\NewRequestEvent;
use Aysheka\Socket\Event\Init\OpenEvent;
use Aysheka\Socket\Event\Init\CloseEvent;
use Aysheka\Socket\Client\Event\ConnectEvent;
use Aysheka\Socket\Server\Event\BindEvent;
use Aysheka\Socket\Event\IO\ReadEvent;
use Aysheka\Socket\Event\IO\WriteEvent;

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(NewRequestEvent::getEventName(), function (NewRequestEvent $event) {

    $socket = $event->getSocket();

    $socket->write("HELLO I'm test server\n");

    while (true) {
        $data  = '';
        $bytes = $socket->read();

        while ($bytes) {
            $data .= $bytes;

            $bytes = $socket->read();
        }

        echo 'Receive from client: ', $data, "\n\n";

        $socket->write('Server reply: ' . microtime(true));
    }


    $socket->write("Closing your socket\n");

});

$eventDispatcher->addListener(OpenEvent::getEventName(), function (OpenEvent $event) {
    echo "Open\n";
});

$eventDispatcher->addListener(CloseEvent::getEventName(), function (CloseEvent $event) {
    echo "Close\n";
});

$eventDispatcher->addListener(ConnectEvent::getEventName(), function (ConnectEvent $event) {
    echo "Connect\n";
});

$eventDispatcher->addListener(BindEvent::getEventName(), function (BindEvent $event) {
    echo "Bind\n";
});

$eventDispatcher->addListener(ReadEvent::getEventName(), function (ReadEvent $event) {
    echo "Read: " . trim($event->getData()) . "\n";
});

$eventDispatcher->addListener(WriteEvent::getEventName(), function (WriteEvent $event) {
    echo "Write: " . trim($event->getData()) . "\n";
});

$server = new \Aysheka\Socket\Server\Server('127.0.0.1', 8089, new \Aysheka\Socket\Address\IP4(), new Type\Stream(), new \Aysheka\Socket\Transport\TCP(), $eventDispatcher);
$server->create();