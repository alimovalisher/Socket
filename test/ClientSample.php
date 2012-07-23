<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Aysheka\Socket\Client;
use Aysheka\Socket\Socket;
use Aysheka\Socket\DomainProtocol;
use Aysheka\Socket\SocketProtocol;
use Aysheka\Socket\SocketType;
use Aysheka\Socket\Event\SocketEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

$eventDispatcher = new EventDispatcher();
$eventDispatcher->addListener(SocketEvent::OPEN, function (SocketEvent $event)
{
    echo "Open\n";
});

$eventDispatcher->addListener(SocketEvent::CLOSE, function (SocketEvent $event)
{
    echo "Close\n";
});

$eventDispatcher->addListener(SocketEvent::CONNECT, function (SocketEvent $event)
{
    echo "Connect\n";
});

$eventDispatcher->addListener(SocketEvent::BIND, function (SocketEvent $event)
{
    echo "Bind\n";
});

$eventDispatcher->addListener(SocketEvent::READ, function (SocketEvent $event)
{
    echo "Read: " . trim($event->getData()) . "\n";
});

$eventDispatcher->addListener(SocketEvent::WRITE, function (SocketEvent $event)
{
    echo "Write: " . trim($event->getData()) . "\n";
});

$client = new Client('127.0.0.1', 8089, DomainProtocol::create(DomainProtocol::IP4), SocketType::create(SocketType::STREAM), SocketProtocol::create(\Aysheka\Socket\SocketProtocol::TCP), $eventDispatcher);

$client->connect();
$client->read();
$client->send('dasdadd');
$client->read();
$client->close();