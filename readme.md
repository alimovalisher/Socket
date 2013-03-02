This library provide functionality for working with socket
=====================

Notice:
1. Library was tested only on TCP, IP4, Stream connection
2. You can find samples(server, client) in test directory


How connect to server
=====================

~~~~~ php
<?php
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Client\Client;
use Aysheka\Socket\Address\IP4;
use Aysheka\Socket\Type\Stream;
use Aysheka\Socket\Transport\TCP;

$client = new Client('127.0.0.1', 8089, new IP4(), new Stream(), new TCP(), new EventDispatcher());
$client->connect();
$client->close();`
~~~~~

And thats all 

How create a server
======================

~~~~~ php
use Aysheka\Socket\Client;
use Aysheka\Socket\Type\Stream;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Aysheka\Socket\Server\Event\NewConnectionEvent;
use Aysheka\Socket\Server\Server;
use Aysheka\Socket\Address\IP4;
use Aysheka\Socket\Transport\TCP;

$eventDispatcher = new EventDispatcher();

$eventDispatcher->addListener(NewConnectionEvent::getEventName(), function (NewConnectionEvent $event) {

    $socket = $event->getSocket();

    $socket->write("HELLO I'm test server\n");

    // Read bytes from socket if available
    while ($read = $socket->read()) {
        echo "Read data: [{$read}]";
        $socket->write('Response');
        usleep(50);
    }
});


$server = new Server('127.0.0.1', 8089, new IP4(), new Stream(), new TCP(), $eventDispatcher);

$server->create();
~~~~~
