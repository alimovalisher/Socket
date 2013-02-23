<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Event\Init\OpenEvent;
use Aysheka\Socket\Event\Init\CloseEvent;
use Aysheka\Socket\Client\Event\ConnectEvent;
use Aysheka\Socket\Server\Event\BindEvent;
use Aysheka\Socket\Event\IO\ReadEvent;
use Aysheka\Socket\Event\IO\WriteEvent;
use Aysheka\Socket\Client\Client;

$eventDispatcher = new EventDispatcher();

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

$client = new Client('127.0.0.1', 8089, new \Aysheka\Socket\Address\IP4(), new \Aysheka\Socket\Type\Stream(), new \Aysheka\Socket\Transport\TCP(), $eventDispatcher);

$client->connect();

//while (true) {
//
//    $data  = '';
//    $bytes = $client->read();
//
//    while ($bytes) {
//        $data .= $bytes;
//
//        $bytes = $client->read();
//    }
//
//    echo 'Receive from server: ', $data, "\n\n";
//    $client->write('Cliet reply: ' . microtime(true));
//
//    usleep(1500);
//}