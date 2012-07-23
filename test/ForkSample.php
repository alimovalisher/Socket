<?php
require_once __DIR__ . '/../vendor/autoload.php';

if (!extension_loaded('pcntl')) {
    die("Pcntl is need for this test");
}

define('SOCKET_TEST_DELAY', 300000);

use Aysheka\Socket\Server;
use Aysheka\Socket\Client;
use Aysheka\Socket\Socket;
use Aysheka\Socket\DomainProtocol;
use Aysheka\Socket\SocketProtocol;
use Aysheka\Socket\SocketType;
use Aysheka\Socket\Event\ServerEvent;
use Aysheka\Socket\Event\SocketEvent;
use Aysheka\Socket\Exception\SocketException;
use Symfony\Component\EventDispatcher\EventDispatcher;

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(ServerEvent::NEW_REQUEST, function (ServerEvent $event)
{
    $socket = $event->getSocket();
    echo get_class($socket) . ": New request\n";

    usleep(rand(SOCKET_TEST_DELAY, SOCKET_TEST_DELAY * 2));

    try {
        $socket->write("HELO\n");
    } catch (SocketException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

    $event->getServer()->stop();
});

$eventDispatcher->addListener(SocketEvent::OPEN, function (SocketEvent $event)
{
    echo get_class($event->getSocket()) . ": Open\n";
});

$eventDispatcher->addListener(SocketEvent::CLOSE, function (SocketEvent $event)
{
    echo get_class($event->getSocket()) . ": Close\n";
});

$eventDispatcher->addListener(SocketEvent::CONNECT, function (SocketEvent $event)
{
    echo get_class($event->getSocket()) . ": Connect\n";
    $event->getSocket()->read();
});

$eventDispatcher->addListener(SocketEvent::BIND, function (SocketEvent $event)
{
    echo get_class($event->getSocket()) . ": Bind\n";
});

$eventDispatcher->addListener(SocketEvent::READ, function (SocketEvent $event)
{
    $socket = $event->getSocket();
    $data   = trim($event->getData());

    usleep(rand(SOCKET_TEST_DELAY, SOCKET_TEST_DELAY * 2));
    echo get_class($socket) . ": Read: $data\n";

    switch ($data) {
        case 'HELO':
            $socket->write('Test string');
            break;
        case 'BYE':
            $socket->close();
            break;
        default:
            if ($socket instanceof Client) {
                $socket->write("BYE\n");
            } else {
                $socket->write("$data\n");
            }
            break;
    }
});

$eventDispatcher->addListener(SocketEvent::WRITE, function (SocketEvent $event)
{
    $socket = $event->getSocket();
    $data   = trim($event->getData());

    echo get_class($socket) . ": Write: $data\n";

    switch ($data) {
        case 'HELO':
            $socket->read();
            break;
        case 'BYE':
            $socket->close();
            break;
        default:
            $socket->read();
            break;
    }
});


$pid = pcntl_fork();
if ($pid == -1) {
    die('could not fork');
} else if ($pid) {
    // we are the parent
    $server = new Server('127.0.0.1', 8089, DomainProtocol::create(DomainProtocol::IP4), SocketType::create(SocketType::STREAM), SocketProtocol::create(\Aysheka\Socket\SocketProtocol::TCP), $eventDispatcher);
    $server->create();

    pcntl_wait($status); //Protect against Zombie children

    $server->close();
} else {
    // we are the child
    usleep(rand(SOCKET_TEST_DELAY, SOCKET_TEST_DELAY * 2));
    $client = new Client('127.0.0.1', 8089, DomainProtocol::create(DomainProtocol::IP4), SocketType::create(SocketType::STREAM), SocketProtocol::create(\Aysheka\Socket\SocketProtocol::TCP), $eventDispatcher);

    try {
        $client->connect();
    } catch (SocketException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}



