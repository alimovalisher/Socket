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

$client->read();

$client->write('Request');

$client->read();

$client->write('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');

$client->read();

$client->close();

echo "End";
