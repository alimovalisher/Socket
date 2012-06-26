<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Aysheka\Socket\Client;
use Aysheka\Socket\Socket;
use Aysheka\Socket\DomainProtocol;
use Aysheka\Socket\SocketProtocol;
use Aysheka\Socket\SocketType;
use Symfony\Component\EventDispatcher\EventDispatcher;

$eventDispatcher = new EventDispatcher();
$client          = new Client('127.0.0.1', 8088, DomainProtocol::create(DomainProtocol::IP4), SocketType::create(SocketType::STREAM), SocketProtocol::create(\Aysheka\Socket\SocketProtocol::TCP), $eventDispatcher);
$client->connect();
echo $client->read();
$client->send('dasdadd');
echo $client->read();
$client->close();